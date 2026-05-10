<?php

namespace App\Models\References;

use CodeIgniter\Model;

class CategorieActivite extends Model
{
    protected $table            = 'ref_categories_activite';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['libelle', 'description'];
}
