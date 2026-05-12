<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\Admin;

class AdminAuthController extends BaseController
{
    public function loginForm()
    {
        if (session()->get('is_logged_in') && session()->get('is_admin')) {
            return redirect()->to('/admin/dashboard');
        }
        return view('admin/auth/login');
    }

    public function login()
    {
        $login = $this->request->getPost('login');
        $password = $this->request->getPost('password');

        $adminModel = new Admin();
        $admin = $adminModel->where('login', $login)->first();

        if (!$admin || !password_verify($password, $admin['mot_de_passe_hash'])) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Identifiants administrateur incorrects');
        }

        session()->set([
            'admin_id' => $admin['id'],
            'admin_name' => $admin['nom'],
            'is_logged_in' => true,
            'is_admin' => true
        ]);

        return redirect()->to('/admin/dashboard')->with('message', 'Bienvenue Administrateur !');
    }

    public function logout()
    {
        session()->remove(['admin_id', 'admin_name', 'is_logged_in', 'is_admin']);
        return redirect()->to('/admin/login')->with('message', 'Vous avez été déconnecté avec succès.');
    }
}
