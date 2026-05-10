<?php

namespace App\Controllers\Utilisateurs;

use App\Controllers\BaseController;

class AbonnementGoldController extends BaseController
{
    public function index($userId)
    {
        $model = new \App\Models\Utilisateurs\AbonnementGold();
        $abonnements = $model->where('utilisateur_id', $userId)->findAll();
        
        return view('abonnement-historique', ['abonnements' => $abonnements]);
    }

    public function store($userId)
    {
        $model = new \App\Models\Utilisateurs\AbonnementGold();
        $data = $this->request->getPost();
        
        // Définir les valeurs par défaut de l'abonnement
        $data['utilisateur_id'] = $userId;
        $data['date_debut'] = date('Y-m-d');
        $data['is_actif'] = 1;
        
        if (empty($data['date_fin'])) {
            $data['date_fin'] = date('Y-m-d', strtotime('+30 days')); // Default: 30 jours
        }
        
        // Logique métier de débit portefeuille serait appelée ici
        // ...
        
        $model->insert($data);
        
        return redirect()->back()->with('message', 'Abonnement Gold souscrit avec succès');
    }

    public function destroy($id)
    {
        $model = new \App\Models\Utilisateurs\AbonnementGold();
        // On désactive l'abonnement
        $model->update($id, ['is_actif' => 0]);
        
        return redirect()->back()->with('message', 'Abonnement Gold résilié');
    }
}
