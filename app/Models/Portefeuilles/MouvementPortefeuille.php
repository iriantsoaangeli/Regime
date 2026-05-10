<?php

namespace App\Models\Portefeuilles;

use CodeIgniter\Model;

class MouvementPortefeuille extends Model
{
    protected $table            = 'mouvements_portefeuille';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = true;
    protected $updatedField     = ''; // pas dans la table
    protected $allowedFields    = [
        'utilisateur_id', 
        'type_transaction_id', 
        'commande_id', 
        'code_id', 
        'montant', 
        'solde_avant', 
        'solde_apres', 
        'libelle'
    ];
}
