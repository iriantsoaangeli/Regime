<?php

namespace App\Models;

use CodeIgniter\Model;

class Genre extends Model
{
    protected $table            = 'ref_genres';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['libelle'];
}
