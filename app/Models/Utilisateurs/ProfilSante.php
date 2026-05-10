<?php

namespace App\Models\Utilisateurs;

use CodeIgniter\Model;

class ProfilSante extends Model
{
    protected $table            = 'profils_sante';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = true;
    protected $updatedField     = '';
    protected $allowedFields    = [
        'utilisateur_id', 
        'taille_cm', 
        'poids_kg', 
        'imc', 
        'objectif_id', 
        'date_mesure'
    ];
}
