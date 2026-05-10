<?php

namespace App\Models\Commandes;

use CodeIgniter\Model;

class Commande extends Model
{
    protected $table            = 'commandes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = true;
    protected $allowedFields    = [
        'utilisateur_id', 
        'tarif_regime_id', 
        'activite_id', 
        'statut_id', 
        'sous_total', 
        'taux_remise', 
        'montant_remise', 
        'total_ttc', 
        'paye_via_portefeuille'
    ];

    public function calculerTotal($sousTotal, $tauxRemise = 0)
    {
        $montantRemise = $sousTotal * ($tauxRemise / 100);
        return [
            'sous_total'     => $sousTotal,
            'taux_remise'    => $tauxRemise,
            'montant_remise' => $montantRemise,
            'total_ttc'      => $sousTotal - $montantRemise
        ];
    }

    public function appliquerRemiseGold($sousTotal)
    {
        // 15% de remise pour les membres Gold
        return $this->calculerTotal($sousTotal, 15);
    }
}
