<?php

namespace App\Models\Portefeuilles;

use CodeIgniter\Model;

class Portefeuille extends Model
{
    protected $table            = 'portefeuilles';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = true;
    protected $createdField     = '';
    protected $allowedFields    = ['utilisateur_id', 'solde'];

    public function crediter($utilisateur_id, $montant)
    {
        // On récupère ou crée le portefeuille de l'utilisateur s'il n'existe pas
        $portefeuille = $this->where('utilisateur_id', $utilisateur_id)->first();
        if ($portefeuille) {
            return $this->update($portefeuille['id'], ['solde' => $portefeuille['solde'] + $montant]);
        } else {
            return $this->insert(['utilisateur_id' => $utilisateur_id, 'solde' => $montant]);
        }
    }

    public function debiter($utilisateur_id, $montant)
    {
        $portefeuille = $this->where('utilisateur_id', $utilisateur_id)->first();
        if ($portefeuille && $portefeuille['solde'] >= $montant) {
            return $this->update($portefeuille['id'], ['solde' => $portefeuille['solde'] - $montant]);
        }
        return false;
    }

    public function soldeSuffisant($utilisateur_id, $montant)
    {
        $portefeuille = $this->where('utilisateur_id', $utilisateur_id)->first();
        return $portefeuille ? ($portefeuille['solde'] >= $montant) : false;
    }
}
