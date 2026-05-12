<?php

namespace App\Controllers\Commandes;

use App\Controllers\BaseController;
use App\Models\Commandes\Commande;
use App\Models\Regimes\TarifRegime;
use App\Models\Portefeuilles\Portefeuille;
use App\Models\Portefeuilles\MouvementPortefeuille;

class CommandeController extends BaseController
{
    public function acheterProgramme()
    {
        $userId = session()->get('user_id') ?? 1;
        $tarifId = $this->request->getPost('tarif_id');
        $activiteId = $this->request->getPost('activite_id');

        $tarifModel = new TarifRegime();
        $tarif = $tarifModel->find($tarifId);
        if (!$tarif) {
            return redirect()->back()->with('error', 'Tarif invalide.');
        }

        $totalPrice = (float) ($tarif['prix'] ?? 0);

        $portefeuilleModel = new Portefeuille();
        $portefeuille = $portefeuilleModel->where('utilisateur_id', $userId)->first();
        
        $solde = $portefeuille ? $portefeuille['solde'] : 0;

        if ($solde < $totalPrice) {
            return redirect()->back()->with('error', 'Solde insuffisant dans votre portefeuille. Veuillez le recharger.');
        }

        // Créer la commande
        $commandeModel = new Commande();
        $commandeId = $commandeModel->insert([
            'utilisateur_id' => $userId,
            'tarif_regime_id' => $tarifId,
            'activite_id' => $activiteId ?: null,
            'statut_id' => 1, // Supposons que 1 = 'Payée' ou 'Validée'
            'sous_total' => $totalPrice, // Normalement on recalcule coté serveur, mais pour la démo on prend le total
            'taux_remise' => 0, // Géré coté frontend actuellement, mais la logique pourrait etre déplacée.
            'montant_remise' => 0,
            'total_ttc' => $totalPrice,
            'paye_via_portefeuille' => 1
        ]);

        // Débiter le portefeuille
        $portefeuilleModel->debiter($userId, $totalPrice);

        // Historique de mouvement
        $mvtModel = new MouvementPortefeuille();
        $mvtModel->insert([
            'utilisateur_id' => $userId,
            'type_transaction_id' => 2, // 2 = Achat / Débit
            'commande_id' => $commandeId,
            'montant' => $totalPrice,
            'solde_avant' => $solde,
            'solde_apres' => $solde - $totalPrice,
            'libelle' => 'Achat du programme santé'
        ]);

        return redirect()->to('/regime')->with('message', 'Régime changé avec succès. Le paiement a été effectué via votre portefeuille.');
    }
}
