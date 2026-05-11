<?php

namespace App\Controllers\Utilisateurs;

use App\Controllers\BaseController;
use App\Models\Utilisateurs\ProfilSante;
use App\Models\References\Objectif;
use App\Models\Regimes\Regime;
use App\Models\Activites\Activite;
use App\Models\Regimes\TarifRegime;
use App\Models\Utilisateurs\Utilisateur;
use App\Models\Portefeuilles\Portefeuille;
use App\Models\Utilisateurs\AbonnementGold;
use App\Models\Portefeuilles\MouvementPortefeuille;

class FrontController extends BaseController
{
    public function myDashboard()
    {
        $userId = session()->get('user_id') ?? 1;

        $userModel = new Utilisateur();
        $profilModel = new ProfilSante();
        $objectifModel = new Objectif();
        $portefeuilleModel = new Portefeuille();

        $user = $userModel->find($userId);
        $profil = $profilModel->where('utilisateur_id', $userId)->first();
        $objectifs = $objectifModel->findAll();
        $portefeuille = $portefeuilleModel->where('utilisateur_id', $userId)->first();
        
        $solde = $portefeuille ? $portefeuille['solde'] : 0;
        
        $isGold = $this->checkGoldStatus($userId);
        
        $data = [
            'user' => $user,
            'profil' => $profil,
            'objectifs' => $objectifs,
            'isGold' => $isGold,
            'solde' => $solde
        ];

        if ($profil) {
            $data['imc_category'] = $this->getImcCategory($profil['imc']);
            $data['suggestion'] = $this->getSuggestion(
                $profil['objectif_id'], 
                $profil['imc'], 
                $profil['poids_kg']
            );
        }

        return view('user-dashboard', $data);
    }

    private function checkGoldStatus($userId)
    {
        $goldModel = new AbonnementGold();
        $abonnement = $goldModel->where('utilisateur_id', $userId)
                                ->where('is_actif', 1)
                                ->orderBy('id', 'DESC')
                                ->first();
        if ($abonnement) {
            return $goldModel->estValide($abonnement['id']);
        }
        return false;
    }

    public function devenirGold()
    {
        return view('gold-offer');
    }

    public function souscrireGold()
    {
        $userId = session()->get('user_id') ?? 1;
        $prixGold = 50000; // Par exemple 50 000 Ar / mois

        $portefeuilleModel = new Portefeuille();
        $portefeuille = $portefeuilleModel->where('utilisateur_id', $userId)->first();
        $solde = $portefeuille ? $portefeuille['solde'] : 0;

        if ($solde < $prixGold) {
            return redirect()->to('/mon-espace')->with('error', 'Solde insuffisant pour devenir membre Gold.');
        }

        // Débiter le portefeuille
        $portefeuilleModel->debiter($userId, $prixGold);

        // Historique de mouvement
        $mvtModel = new MouvementPortefeuille();
        $mvtModel->insert([
            'utilisateur_id' => $userId,
            'type_transaction_id' => 2, // débit
            'montant' => $prixGold,
            'solde_avant' => $solde,
            'solde_apres' => $solde - $prixGold,
            'libelle' => 'Souscription Abonnement Gold'
        ]);

        // Activer l'abonnement
        $goldModel = new AbonnementGold();
        $goldModel->insert([
            'utilisateur_id' => $userId,
            'montant_paye' => $prixGold,
            'date_debut' => date('Y-m-d'),
            'date_fin' => date('Y-m-d', strtotime('+30 days')),
            'is_actif' => 1
        ]);

        return redirect()->to('/mon-espace')->with('message', 'Félicitations ! Vous êtes maintenant membre Gold et bénéficiez de -15% de remise.');
    }

    private function getImcCategory($imc)
    {
        if ($imc < 18.5) return ['label' => 'Insuffisance pondérale', 'color' => 'orange'];
        if ($imc < 25) return ['label' => 'Poids normal', 'color' => 'green'];
        if ($imc < 30) return ['label' => 'Surpoids', 'color' => 'orange'];
        return ['label' => 'Obésité', 'color' => 'red'];
    }

    private function getSuggestion($objectif_id, $imc, $poidsActuel)
    {
        $regimeModel = new Regime();
        $tarifRegimeModel = new TarifRegime();
        $activiteModel = new Activite();

        $direction = ($objectif_id == 1) ? -1 : (($objectif_id == 2) ? 1 : 0);

        if ($direction == 0) {
            $regimes = $regimeModel->where('is_actif', 1)->findAll();
            $bestRegime = !empty($regimes) ? $regimes[0] : null;
        } else {
            $operator = ($direction > 0) ? '>' : '<';
            $tarifs = $tarifRegimeModel->where("variation_poids_kg $operator", 0)
                                       ->orderBy("ABS(variation_poids_kg)", 'DESC')
                                       ->findAll();
            
            if (empty($tarifs)) {
                $bestRegime = null;
            } else {
                $bestTarif = $tarifs[0];
                $bestRegime = $regimeModel->find($bestTarif['regime_id']);
                $bestRegime['best_tarif'] = $bestTarif;
            }
        }

        if (!$bestRegime) return [];

        $activites = $activiteModel->select('activites_sportives.*')
                                   ->join('objectif_activites', 'objectif_activites.activite_id = activites_sportives.id', 'inner')
                                   ->where('activites_sportives.is_actif', 1)
                                   ->where('objectif_activites.objectif_id', $objectif_id)
                                   ->findAll();
        $bestActivite = !empty($activites) ? $activites[array_rand($activites)] : null;

        if (!isset($bestRegime['best_tarif'])) {
            $tarifsFallback = $tarifRegimeModel->where('regime_id', $bestRegime['id'])->findAll();
            $bestRegime['best_tarif'] = !empty($tarifsFallback) ? $tarifsFallback[0] : ['prix'=> 0, 'duree_jours'=> 0, 'variation_poids_kg'=>0];
        }

        return [
            'regime' => $bestRegime,
            'tarif' => $bestRegime['best_tarif'],
            'activite' => $bestActivite
        ];
    }
}
