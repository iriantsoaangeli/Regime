<?php

namespace App\Models\Activites;

use CodeIgniter\Model;

class Activite extends Model
{
    protected $table            = 'activites_sportives';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = true;
    protected $updatedField     = '';
    protected $allowedFields    = [
        'categorie_id', 
        'nom', 
        'description', 
        'duree_jours', 
        'prix', 
        'is_actif'
    ];
}
