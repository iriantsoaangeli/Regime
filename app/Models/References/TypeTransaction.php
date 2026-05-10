<?php

namespace App\Models\References;

use CodeIgniter\Model;

class TypeTransaction extends Model
{
    protected $table            = 'ref_types_transaction';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['libelle', 'sens'];
}
