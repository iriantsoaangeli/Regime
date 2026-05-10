<?php

namespace App\Models\Portefeuilles;

use CodeIgniter\Model;

class CodePortefeuille extends Model
{
    protected $table            = 'codes_portefeuille';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = true;
    protected $updatedField     = '';
    protected $allowedFields    = [
        'code', 
        'montant', 
        'is_utilise', 
        'utilise_par_id', 
        'utilise_le', 
        'expire_le'
    ];

    public function estValide($code)
    {
        $codeData = $this->where('code', $code)->first();
        if (!$codeData || $codeData['is_utilise'] == 1) {
            return false;
        }

        if ($this->estExpire($codeData['expire_le'])) {
            return false;
        }

        return true;
    }

    public function estExpire($expire_le)
    {
        if (empty($expire_le)) {
            return false;
        }
        
        return strtotime($expire_le) < time();
    }
}
