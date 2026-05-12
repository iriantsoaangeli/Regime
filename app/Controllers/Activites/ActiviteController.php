<?php

namespace App\Controllers\Activites;

use App\Controllers\BaseController;
use App\Models\Activites\Activite;
use App\Models\Activites\ObjectifActivite;
use App\Models\Utilisateurs\ProfilSante;
use App\Models\References\Objectif;

class ActiviteController extends BaseController
{
    public function index()
    {
        $model = new Activite();
        $data['activites'] = $model->orderBy('id', 'DESC')->findAll();
        
        return view('admin-sport', $data);
    }

    public function create()
    {
        if ($this->request->getMethod() === 'post') {
            $model = new Activite();
            $data = $this->request->getPost();
            
            $data['is_actif'] = isset($data['is_actif']) ? 1 : 0;
            $model->insert($data);
            
            return redirect()->to('/admin/sport')->with('message', 'Activité ajoutée avec succès.');
        }

        // Fetch categories
        $categoryModel = new \App\Models\References\CategorieActivite();
        $data['categories'] = $categoryModel->findAll();

        return view('admin-sport-form', $data);
    }

    public function edit($id)
    {
        $model = new Activite();
        
        if ($this->request->getMethod() === 'post') {
            $data = $this->request->getPost();
            $data['is_actif'] = isset($data['is_actif']) ? 1 : 0;
            $model->update($id, $data);
            
            return redirect()->to('/admin/sport')->with('message', 'Activité mise à jour avec succès.');
        }

        $data['activite'] = $model->find($id);
        if (!$data['activite']) {
            return redirect()->to('/admin/sport')->with('error', 'Activité introuvable.');
        }

        // Fetch categories
        $categoryModel = new \App\Models\References\CategorieActivite();
        $data['categories'] = $categoryModel->findAll();

        return view('admin-sport-form', $data);
    }

    public function destroy($id)
    {
        $model = new Activite();
        $model->update($id, ['is_actif' => 0]);
        
        return redirect()->to('/admin/sport')->with('message', 'Activité désactivée.');
    }

        public function sport(): string
    {
        $userId = session()->get('user_id');

        $profilModel = new ProfilSante();
        $objectifModel = new Objectif();
        $objectifActiviteModel = new ObjectifActivite();
        $activiteModel = new Activite();

        $profil = $userId ? $profilModel->where('utilisateur_id', $userId)->first() : null;
        $imc = $profil['imc'] ?? null;

        $objectifId = $profil['objectif_id'] ?? null;
        if (!$objectifId && $imc !== null) {
            $objectifId = ($imc >= 25) ? 'perte' : 'gain';
        }

        $objectif = null;
        $objectifType = null;
        if (is_numeric($objectifId)) {
            $objectif = $objectifModel->find($objectifId);
        }

        if ($objectif) {
            $label = strtolower($objectif['libelle'] ?? '');
            if (str_contains($label, 'augmenter')) {
                $objectifType = 'gain';
            } elseif (str_contains($label, 'duire')) {
                $objectifType = 'perte';
            }
        }

        if (!$objectif && is_string($objectifId)) {
            if ($objectifId === 'gain') {
                $objectif = $objectifModel->like('libelle', 'augmenter', 'both')->first();
                $objectifType = 'gain';
            } elseif ($objectifId === 'perte') {
                $objectif = $objectifModel->like('libelle', 'duire', 'both')->first();
                $objectifType = 'perte';
            }
        }

        if (!$objectifType && $imc !== null) {
            $objectifType = ($imc >= 25) ? 'perte' : 'gain';
        }

        $objectifIdFinal = $objectif['id'] ?? null;
        $activitesRecommandees = [];
        if ($objectifIdFinal) {
            $activitesRecommandees = $activiteModel->select('activites_sportives.*')
                ->join('objectif_activites', 'objectif_activites.activite_id = activites_sportives.id', 'inner')
                ->where('objectif_activites.objectif_id', $objectifIdFinal)
                ->where('activites_sportives.is_actif', 1)
                ->orderBy('activites_sportives.nom', 'ASC')
                ->findAll();
        }


        return view('sport', [
            'objectif' => $objectif,
            'objectifType' => $objectifType,
            'imc' => $imc,
            'activitesRecommandees' => $activitesRecommandees
        ]);
    }
}
