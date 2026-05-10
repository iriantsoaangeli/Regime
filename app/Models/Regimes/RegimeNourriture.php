<?php

namespace App\Models\Regimes;

use CodeIgniter\Model;

class RegimeNourriture extends Model
{
    protected $table            = 'regime_nourritures';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'regime_id', 
        'nourriture_id', 
        'pct_nourriture'
    ];
}
