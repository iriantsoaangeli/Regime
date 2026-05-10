<?php

namespace App\Models\Utilisateurs;

use CodeIgniter\Model;

class Utilisateur extends Model
{
    protected $table            = 'utilisateurs';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = true;
    protected $allowedFields    = [
        'nom', 
        'prenom', 
        'email', 
        'mot_de_passe_hash', 
        'genre_id', 
        'date_naissance', 
        'is_active'
    ];

    public function estGold($utilisateur_id)
    {
        $abonnementModel = new AbonnementGold();
        $abonnement = $abonnementModel->where('utilisateur_id', $utilisateur_id)
                                      ->where('is_actif', 1)
                                      ->where('date_debut <=', date('Y-m-d'))
                                      ->groupStart()
                                        ->where('date_fin >=', date('Y-m-d'))
                                        ->orWhere('date_fin', null)
                                      ->groupEnd()
                                      ->first();
        
        return !empty($abonnement);
    }
}
