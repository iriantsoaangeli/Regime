<?php

namespace App\Controllers\Utilisateurs;

use App\Controllers\BaseController;
use App\Models\Utilisateurs\AbonnementGold;
use App\Models\Portefeuilles\Portefeuille;
use App\Models\Portefeuilles\MouvementPortefeuille;

class AbonnementGoldController extends BaseController
{
    public function index($userId)
    {
        $model = new AbonnementGold();
        $abonnements = $model->where('utilisateur_id', $userId)->findAll();
        
        return view('abonnement-historique', ['abonnements' => $abonnements]);
    }

    public function store($userId)
    {
        $model = new AbonnementGold();
        $data = $this->request->getPost();
        
        // Définir les valeurs par défaut de l'abonnement
        $data['utilisateur_id'] = $userId;
        $data['date_debut'] = date('Y-m-d');
        $data['is_actif'] = 1;
        
        // fin static : modifiable
        if (empty($data['date_fin'])) {
            $data['date_fin'] = date('Y-m-d', strtotime('+30 days'));
        }
        
        // Logique métier de débit portefeuille si solde insuffisant val par defaut
        $montantAbonnement = !empty($data['montant_paye']) ? $data['montant_paye'] : 50000.00;
        $data['montant_paye'] = $montantAbonnement;

        $portefeuilleModel = new Portefeuille();
        if (!$portefeuilleModel->soldeSuffisant($userId, $montantAbonnement)) {
            return redirect()->back()->with('error', 'Solde du portefeuille insuffisant pour souscrire à l\'abonnement Gold');
        }

        // Récupérer solde
        $portefeuille = $portefeuilleModel->where('utilisateur_id', $userId)->first();
        $soldeAvant = $portefeuille ? $portefeuille['solde'] : 0.00;

        // Débit
        $portefeuilleModel->debiter($userId, $montantAbonnement);
        $soldeApres = $soldeAvant - $montantAbonnement;

        // Enregistrer le mouvement (Achat / ID 2)
        $mvtModel = new MouvementPortefeuille();
        $mvtModel->insert([
            'utilisateur_id'      => $userId,
            'type_transaction_id' => 2,
            'montant'             => $montantAbonnement,
            'solde_avant'         => $soldeAvant,
            'solde_apres'         => $soldeApres,
            'libelle'             => 'Souscription abonnement Gold'
        ]);
        
        $model->insert($data);
        
        return redirect()->back()->with('message', 'Abonnement Gold souscrit avec succès');
    }

    public function destroy($id)
    {
        $model = new AbonnementGold();
        // On désactive l'abonnement
        $model->update($id, ['is_actif' => 0]);
        
        return redirect()->back()->with('message', 'Abonnement Gold résilié');
    }
}
