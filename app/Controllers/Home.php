<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        if (session()->get('is_logged_in')) {
            if (session()->get('is_admin')) {
                return redirect()->to('/admin/dashboard');
            }
            return redirect()->to('/mon-espace');
        }
        return view('accueil-invite');
    }

    public function regime(): string
    {
        return view('regime');
    }

    public function sport(): string
    {
        return view('sport');
    }

    public function dashboard(): string
    {
        $utilisateurModel = new \App\Models\Utilisateurs\Utilisateur();
        $abonnementModel = new \App\Models\Utilisateurs\AbonnementGold();
        $regimeModel = new \App\Models\Regimes\Regime();
        $commandeModel = new \App\Models\Commandes\Commande();

        $today = date('Y-m-d');

        // Total utilisateurs
        $totalUsers = $utilisateurModel->countAllResults();

        // Total Gold Members (actifs)
        $totalGold = $abonnementModel->where('is_actif', 1)
                                     ->groupStart()
                                         ->where('date_fin >=', $today)
                                         ->orWhere('date_fin', null)
                                     ->groupEnd()
                                     ->countAllResults();

        // Total Régimes actifs
        $totalRegimes = $regimeModel->where('is_actif', 1)->countAllResults();

        // Chiffre d'affaires total
        $totalRevenue = $commandeModel->selectSum('total_ttc')->get()->getRow()->total_ttc ?? 0;

        $data = [
            'totalUsers'   => $totalUsers,
            'totalGold'    => $totalGold,
            'totalRegimes' => $totalRegimes,
            'totalRevenue' => $totalRevenue
        ];

        return view('dashboard', $data);
    }
}
