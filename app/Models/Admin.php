<?php

namespace App\Models;

use CodeIgniter\Model;

class Admin extends Model
{
    protected $table = 'admins';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['login', 'mot_de_passe_hash', 'nom'];

    public function verifierMotDePasse($hash, $plain)
    {
        return password_verify($plain, $hash);
    }
}
