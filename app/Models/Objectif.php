<?php

namespace App\Models;

use CodeIgniter\Model;

class Objectif extends Model
{
    protected $table            = 'ref_objectifs';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['libelle', 'description'];
}
