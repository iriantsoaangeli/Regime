<?php

namespace App\Models\Activites;

use CodeIgniter\Model;

class ObjectifActivite extends Model
{
    protected $table            = 'objectif_activites';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'objectif_id', 
        'activite_id'
    ];
}
