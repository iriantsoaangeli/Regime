<?php

namespace App\Controllers\Utilisateurs;

use App\Controllers\BaseController;
use App\Models\Utilisateurs\Utilisateur;
use App\Models\Utilisateurs\ProfilSante;
use App\Models\References\Objectif;
use App\Models\Commandes\Commande;
use App\Models\Regimes\TarifRegime;
use App\Models\Regimes\Regime;
use App\Models\Regimes\RegimeNourriture;
use App\Models\Regimes\Nourriture;
use App\Models\Activites\Activite;

class UtilisateurController extends BaseController
{
    public function index()
    {
        $model = new Utilisateur();
        $data['utilisateurs'] = $model->findAll();

        return view('admin-utilisateurs', $data); // Vue à créer pour le back-office
    }

    public function show($id)
    {
        $model = new Utilisateur();
        $data['utilisateur'] = $model->find($id);

        return view('utilisateur-detail', $data);
    }

    public function home()
    {
        if (session()->get('is_logged_in')) {
            if (session()->get('is_admin')) {
                return redirect()->to('/admin/dashboard');
            }
            $userId = session()->get('user_id');

            $profilModel = new ProfilSante();
            $objectifModel = new Objectif();
            $commandeModel = new Commande();
            $tarifRegimeModel = new TarifRegime();
            $regimeModel = new Regime();
            $regimeNourritureModel = new RegimeNourriture();
            $nourritureModel = new Nourriture();
            $activiteModel = new Activite();

            $profil = $profilModel->where('utilisateur_id', $userId)->first();
            $objectif = null;
            if (!empty($profil['objectif_id'])) {
                $objectif = $objectifModel->find($profil['objectif_id']);
            }

            $commande = $commandeModel->where('utilisateur_id', $userId)
                ->orderBy('id', 'DESC')
                ->first();
            $regimeActuel = null;
            $regimeNourritures = [];
            if (!empty($commande['tarif_regime_id'])) {
                $tarif = $tarifRegimeModel->find($commande['tarif_regime_id']);
                if (!empty($tarif['regime_id'])) {
                    $regimeActuel = $regimeModel->find($tarif['regime_id']);
                    if (!empty($regimeActuel)) {
                        $regimeNourritures = $regimeNourritureModel
                            ->select('regime_nourritures.pct_nourriture, nourritures.nom, nourritures.description')
                            ->join($nourritureModel->getTable(), 'nourritures.id = regime_nourritures.nourriture_id', 'inner')
                            ->where('regime_nourritures.regime_id', $regimeActuel['id'])
                            ->findAll();
                    }
                }
            }

            $activiteIds = $commandeModel->select('activite_id')
                ->where('utilisateur_id', $userId)
                ->where('activite_id IS NOT NULL', null, false)
                ->findColumn('activite_id');
            $activites = [];
            if (!empty($activiteIds)) {
                $activiteIds = array_values(array_unique($activiteIds));
                $activites = $activiteModel->whereIn('id', $activiteIds)->findAll();
            }

            return view('index-front', [
                'profil' => $profil,
                'objectif' => $objectif,
                'regimeActuel' => $regimeActuel,
                'regimeNourritures' => $regimeNourritures,
                'activites' => $activites
            ]);
        }
        return view('accueil-invite');
    }


    public function store()
    {
        // inscription front office
        $model = new Utilisateur();
        $data = $this->request->getPost();

        // Hachage du mot de passe
        if (isset($data['mot_de_passe'])) {
            $data['mot_de_passe_hash'] = password_hash($data['mot_de_passe'], PASSWORD_DEFAULT);
            unset($data['mot_de_passe']);
        }

        $data['is_active'] = 1;
        $model->insert($data);

        return redirect()->to('/login')->with('message', 'Inscription réussie');
    }

    public function update($id)
    {
        $model = new Utilisateur();
        $data = $this->request->getPost();

        // Mise à jour du mot de passe si renseigné
        if (!empty($data['mot_de_passe'])) {
            $data['mot_de_passe_hash'] = password_hash($data['mot_de_passe'], PASSWORD_DEFAULT);
            unset($data['mot_de_passe']);
        }

        $model->update($id, $data);

        return redirect()->back()->with('message', 'Profil mis à jour avec succès');
    }

    public function destroy($id)
    {
        $model = new Utilisateur();
        // Désactivation logique ("soft delete" manuel)
        $model->update($id, ['is_active' => 0]);

        return redirect()->to('/admin/utilisateurs')->with('message', 'Compte désactivé');
    }
}
