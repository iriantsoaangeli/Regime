<?php

namespace App\Models;

use CodeIgniter\Model;

class StatutCommande extends Model
{
    protected $table            = 'ref_statuts_commande';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['libelle', 'description'];
}
