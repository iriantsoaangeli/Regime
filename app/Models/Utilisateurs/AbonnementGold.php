<?php

namespace App\Models\Utilisateurs;

use CodeIgniter\Model;

class AbonnementGold extends Model
{
    protected $table            = 'abonnements_gold';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = true;
    protected $updatedField     = ''; // Pas de champ updated_at dans la table
    protected $allowedFields    = [
        'utilisateur_id', 
        'montant_paye', 
        'date_debut', 
        'date_fin', 
        'is_actif'
    ];

    public function estValide($id)
    {
        $abonnement = $this->find($id);
        if (!$abonnement) {
            return false;
        }

        $today = date('Y-m-d');
        if ($abonnement['is_actif'] == 1 && $abonnement['date_debut'] <= $today) {
            if ($abonnement['date_fin'] === null || $abonnement['date_fin'] >= $today) {
                return true;
            }
        }
        return false;
    }
}
