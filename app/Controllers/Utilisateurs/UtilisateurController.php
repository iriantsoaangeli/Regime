<?php

namespace App\Controllers\Utilisateurs;

use App\Controllers\BaseController;
use App\Models\Utilisateurs\Utilisateur;

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
