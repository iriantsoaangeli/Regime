<?php

namespace App\Models\Regimes;

use CodeIgniter\Model;

class Regime extends Model
{
    protected $table            = 'regimes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = true;
    protected $allowedFields    = [
        'nom', 
        'description', 
        'is_actif'
    ];
}
