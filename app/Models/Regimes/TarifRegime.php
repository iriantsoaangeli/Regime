<?php

namespace App\Models\Regimes;

use CodeIgniter\Model;

class TarifRegime extends Model
{
    protected $table            = 'tarifs_regime';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'regime_id', 
        'duree_jours', 
        'prix', 
        'variation_poids_kg', 
        'is_actif'
    ];
}
