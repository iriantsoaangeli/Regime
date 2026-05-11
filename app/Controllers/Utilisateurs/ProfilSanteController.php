<?php

namespace App\Controllers\Utilisateurs;

use App\Controllers\BaseController;
use App\Models\Utilisateurs\ProfilSante;
use App\Models\Utilisateurs\HistoriqueImc;

class ProfilSanteController extends BaseController
{
    public function show($userId)
    {
        $model = new ProfilSante();
        $profil = $model->where('utilisateur_id', $userId)->first();
        
        return view('profil-sante', ['profil' => $profil]);
    }

    public function store($userId)
    {
        $model = new ProfilSante();
        $histModel = new HistoriqueImc();
        
        $data = $this->request->getPost();
        $data['utilisateur_id'] = $userId;
        $data['date_mesure'] = date('Y-m-d');
        
        // Calcul IMC : Poids (kg) / Taille (m)^2
        $taille_m = floatval($data['taille_cm']) / 100;
        $data['imc'] = ($taille_m > 0) ? round($data['poids_kg'] / ($taille_m * $taille_m), 2) : 0;
        
        $model->insert($data);
        
        // Création du premier historique BMI
        $histModel->insert([
            'utilisateur_id' => $userId,
            'poids_kg'       => $data['poids_kg'],
            'taille_cm'      => $data['taille_cm'],
            'imc'            => $data['imc'],
            'objectif_id'    => $data['objectif_id'],
            'date_mesure'    => $data['date_mesure']
        ]);
        
        return redirect()->to('/dashboard')->with('message', 'Profil santé créé');
    }

    public function update($userId)
    {
        $model = new ProfilSante();
        $histModel = new HistoriqueImc();
        
        $profil = $model->where('utilisateur_id', $userId)->first();

        $data = $this->request->getPost();
        // Fallbacks au cas où le profil existait déjà
        $poids = $data['poids_kg'] ?? ($profil['poids_kg'] ?? 0);
        $taille = $data['taille_cm'] ?? ($profil['taille_cm'] ?? 0);
        $objectif = $data['objectif_id'] ?? ($profil['objectif_id'] ?? null);
        
        // Recalcul IMC
        $taille_m = floatval($taille) / 100;
        $imc = ($taille_m > 0) ? round($poids / ($taille_m * $taille_m), 2) : 0;
        
        $updateData = [
            'poids_kg'    => $poids,
            'taille_cm'   => $taille,
            'imc'         => $imc,
            'objectif_id' => $objectif,
            'date_mesure' => date('Y-m-d')
        ];
        
        if ($profil) {
            $model->update($profil['id'], $updateData);
        } else {
            $updateData['utilisateur_id'] = $userId;
            $model->insert($updateData);
        }
        
        // Archivage de la nouvelle mesure
        $updateData['utilisateur_id'] = $userId;
        $histModel->insert($updateData);
        
        return redirect()->to('/mon-espace')->with('message', 'Profil santé mis à jour avec le nouveau calcul IMC');
    }
}
