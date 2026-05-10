<?php

namespace App\Models\Regimes;

use CodeIgniter\Model;

class ObjectifRegime extends Model
{
    protected $table            = 'objectif_regime';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'objectif_id', 
        'regime_id'
    ];
}
