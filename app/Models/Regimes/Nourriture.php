<?php

namespace App\Models\Regimes;

use CodeIgniter\Model;

class Nourriture extends Model
{
    protected $table            = 'nourritures';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = true;
    protected $updatedField     = '';
    protected $allowedFields    = [
        'nom', 
        'description', 
        'is_actif'
    ];
}
