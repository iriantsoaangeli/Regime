<?php

namespace App\Controllers\Commandes;

use App\Controllers\BaseController;
use App\Models\Commandes\Commande;
use App\Models\Commandes\SuiviCommande;
use App\Models\Portefeuilles\Portefeuille;
use App\Models\Portefeuilles\MouvementPortefeuille;
use App\Models\Utilisateurs\Utilisateur;
use App\Models\Regimes\TarifRegime;
use App\Models\Activites\Activite;

class CommandeController extends BaseController
{
    public function index()
    {
        // Toutes les commandes (Admin)
        $model = new Commande();
        $data['commandes'] = $model->findAll();
        
        return view('admin-commandes', $data);
    }

    public function mesCommandes($userId)
    {
        // Commandes d'un utilisateur specifique
        $model = new Commande();
        $data['commandes'] = $model->where('utilisateur_id', $userId)->findAll();
        
        return view('mes-commandes', $data);
    }

    public function show($id)
    {
        $model = new Commande();
        $data['commande'] = $model->find($id);
        
        return view('commande-detail', $data);
    }

    public function store()
    {
        $commandeModel = new Commande();
        $tarifRegimeModel = new TarifRegime();
        $activiteModel = new Activite();
        $utilisateurModel = new Utilisateur();
        
        $userId = session()->get('user_id'); // Ou via une requête
        if (!$userId) return redirect()->back()->with('error', 'Utilisateur non connecté');

        $tarifRegimeId = $this->request->getPost('tarif_regime_id');
        $activiteId = $this->request->getPost('activite_id');
        $payeViaPortefeuille = $this->request->getPost('paye_via_portefeuille') ? 1 : 0;
        
        // Calcul du sous-total
        $tarif = $tarifRegimeModel->find($tarifRegimeId);
        $sousTotal = $tarif['prix'];
        
        if (!empty($activiteId)) {
            $activite = $activiteModel->find($activiteId);
            if ($activite) $sousTotal += $activite['prix'];
        }
        
        // Option Gold (remise 15%)
        $estGold = $utilisateurModel->estGold($userId);
        $calculs = $estGold ? $commandeModel->appliquerRemiseGold($sousTotal) : $commandeModel->calculerTotal($sousTotal, 0);
        
        // 1 = En attente (Paiement non confirmé)
        $statutInitial = 1; 
        $portefeuilleModel = new Portefeuille();

        // Si l'utilisateur choisit de payer avec son portefeuille, vérifier s'il a les fonds
        if ($payeViaPortefeuille === 1) {
            if (!$portefeuilleModel->soldeSuffisant($userId, $calculs['total_ttc'])) {
                return redirect()->back()->with('error', 'Solde insuffisant');
            }
            $statutInitial = 2;
        }
        
        $data = [
            'utilisateur_id'        => $userId,
            'tarif_regime_id'       => $tarifRegimeId,
            'activite_id'           => $activiteId ?: null,
            'statut_id'             => $statutInitial,
            'sous_total'            => $calculs['sous_total'],
            'taux_remise'           => $calculs['taux_remise'],
            'montant_remise'        => $calculs['montant_remise'],
            'total_ttc'             => $calculs['total_ttc'],
            'paye_via_portefeuille' => $payeViaPortefeuille
        ];
        
        $commandeId = $commandeModel->insert($data, true);
        
        // Mouvement de portefeuille une fois la commande validée
        if ($payeViaPortefeuille === 1) {
            $portefeuille = $portefeuilleModel->where('utilisateur_id', $userId)->first();
            $soldeAvant = $portefeuille ? $portefeuille['solde'] : 0.00;
            
            // Débiter
            $portefeuilleModel->debiter($userId, $calculs['total_ttc']);
            $soldeApres = $soldeAvant - $calculs['total_ttc'];
            
            // Loguer le mouvement de DEBIT (ID 2 = Achat commande)
            $mvtModel = new MouvementPortefeuille();
            $mvtModel->insert([
                'utilisateur_id'      => $userId,
                'type_transaction_id' => 2, 
                'commande_id'         => $commandeId,
                'montant'             => $calculs['total_ttc'],
                'solde_avant'         => $soldeAvant,
                'solde_apres'         => $soldeApres,
                'libelle'             => 'Achat de la commande #' . $commandeId
            ]);
        }
        
        // Créer l'historique du statut
        $this->insererSuivi($commandeId, $statutInitial, "Création de la commande");
        
        return redirect()->to('/mes-commandes')->with('message', 'Commande enregistrée avec succès');
    }

    public function changerStatut($id, $statutId)
    {
        $model = new Commande();
        $model->update($id, ['statut_id' => $statutId]);
        
        $this->insererSuivi($id, $statutId, "Statut mis à jour par l'admin");
        
        return redirect()->back()->with('message', 'Statut mis à jour');
    }

    public function annuler($id)
    {
        $model = new Commande();
        $commande = $model->find($id);
        
        // 5 = Statut Annulée
        if ($commande && $commande['statut_id'] != 5) { 
            // Rembourser si déjà payé via portefeuille (Statut 2 = Confirmée, 3 = Active)
            if ($commande['paye_via_portefeuille'] == 1 && in_array($commande['statut_id'], [2, 3])) {
                 $portefeuilleModel = new Portefeuille();
                 
                 $portefeuille = $portefeuilleModel->where('utilisateur_id', $commande['utilisateur_id'])->first();
                 $soldeAvant = $portefeuille ? $portefeuille['solde'] : 0.00;
                 
                 $portefeuilleModel->crediter($commande['utilisateur_id'], $commande['total_ttc']);
                 $soldeApres = $soldeAvant + $commande['total_ttc'];
                 
                 // Loguer le remboursement (ID 3 = Remboursement)
                 $mvtModel = new MouvementPortefeuille();
                 $mvtModel->insert([
                     'utilisateur_id'      => $commande['utilisateur_id'],
                     'type_transaction_id' => 3, 
                     'commande_id'         => $commande['id'],
                     'montant'             => $commande['total_ttc'],
                     'solde_avant'         => $soldeAvant,
                     'solde_apres'         => $soldeApres,
                     'libelle'             => 'Remboursement de la commande annulée #' . $commande['id']
                 ]);
            }
            
            $model->update($id, ['statut_id' => 5]);
            $this->insererSuivi($id, 5, "Commande annulée par l'utilisateur ou l'admin");
        }
        
        return redirect()->back()->with('message', 'Commande annulée');
    }

    private function insererSuivi($commandeId, $statutId, $commentaire = "")
    {
        $suiviModel = new SuiviCommande();
        $suiviModel->insert([
            'commande_id' => $commandeId,
            'statut_id'   => $statutId,
            'commentaire' => $commentaire
        ]);
    }
}
