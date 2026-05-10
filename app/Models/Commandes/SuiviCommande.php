<?php

namespace App\Models\Commandes;

use CodeIgniter\Model;

class SuiviCommande extends Model
{
    protected $table            = 'suivi_commandes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = true;
    protected $updatedField     = ''; // pas dans la table
    protected $allowedFields    = [
        'commande_id', 
        'statut_id', 
        'commentaire'
    ];
}
