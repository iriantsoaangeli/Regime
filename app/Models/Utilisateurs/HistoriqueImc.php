<?php

namespace App\Models\Utilisateurs;

use CodeIgniter\Model;

class HistoriqueImc extends Model
{
    protected $table            = 'historique_imc';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = true;
    protected $updatedField     = '';
    protected $allowedFields    = [
        'utilisateur_id', 
        'poids_kg', 
        'taille_cm', 
        'imc', 
        'objectif_id', 
        'date_mesure'
    ];
}
