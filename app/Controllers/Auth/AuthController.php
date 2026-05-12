<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\Utilisateurs\Utilisateur;
use App\Models\References\Genre;
use App\Models\References\Objectif;
use App\Models\Utilisateurs\ProfilSante;
use App\Models\Portefeuilles\Portefeuille;

/**
 * AuthController
 * Gère l'authentification des utilisateurs et administrateurs
 * - Inscription (2 étapes)
 * - Connexion
 * - Déconnexion
 * - Gestion des sessions
 */
class AuthController extends BaseController
{
    /**
     * Page de login utilisateur
     */
    public function loginPage()
    {
        if (session()->get('is_logged_in')) {
            return redirect()->to(session()->get('is_admin') ? '/admin/dashboard' : '/mon-espace');
        }
        return view('auth/login');
    }

    /**
     * Traitement du login utilisateur
     */
    public function loginSubmit()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $userModel = new Utilisateur();
        $user = $userModel->where('email', $email)->first();

        if (!$user) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Email ou mot de passe incorrect');
        }

        if (!password_verify($password, $user['mot_de_passe_hash'])) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Email ou mot de passe incorrect');
        }

        if ($user['is_active'] != 1) {
            return redirect()->back()
                ->with('error', 'Compte désactivé');
        }

        // Connexion réussie - créer la session
        session()->set([
            'user_id' => $user['id'],
            'user_email' => $user['email'],
            'user_name' => $user['prenom'] . ' ' . $user['nom'],
            'is_logged_in' => true,
            'is_admin' => false
        ]);

        return redirect()->to('/mon-espace')->with('message', 'Bienvenue!');
    }

    /**
     * Page d'inscription - Étape 1
     */
    public function registerStep1()
    {
        if (session()->get('is_logged_in')) {
            return redirect()->to(session()->get('is_admin') ? '/admin/dashboard' : '/mon-espace');
        }

        $genreModel = new Genre();
        $data['genres'] = $genreModel->findAll();

        return view('auth/register-step1', $data);
    }

    /**
     * Traitement étape 1 - Informations personnelles
     */
    public function registerStep1Submit()
    {
        $rules = [
            'nom'       => 'required|min_length[2]|max_length[100]',
            'prenom'    => 'required|min_length[2]|max_length[100]',
            'email'     => 'required|valid_email|is_unique[utilisateurs.email]',
            'genre_id'  => 'required|numeric',
            'password'  => 'required|min_length[8]|max_length[255]',
            'password_confirm' => 'required|matches[password]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // Stocker les données en session pour l'étape 2
        $tempData = [
            'nom'         => $this->request->getPost('nom'),
            'prenom'      => $this->request->getPost('prenom'),
            'email'       => $this->request->getPost('email'),
            'genre_id'    => $this->request->getPost('genre_id'),
            'password'    => $this->request->getPost('password')
        ];

        session()->setTempdata('register_step1', $tempData, 3600); // 1 heure de validité

        return redirect()->to(url_to('register.step2'));
    }

    /**
     * Page d'inscription - Étape 2
     */
    public function registerStep2()
    {
        if (session()->get('is_logged_in')) {
            return redirect()->to(session()->get('is_admin') ? '/admin/dashboard' : '/mon-espace');
        }

        // Vérifier que l'étape 1 est complétée
        if (!session()->getTempdata('register_step1')) {
            return redirect()->to(url_to('register.step1'))
                ->with('error', 'Veuillez d\'abord compléter l\'étape 1');
        }

        $objectifModel = new Objectif();
        $data['objectifs'] = $objectifModel->findAll();

        return view('auth/register-step2', $data);
    }

    /**
     * Traitement étape 2 - Données de santé et création du compte
     */
    public function registerStep2Submit()
    {
        $step1Data = session()->getTempdata('register_step1');
        if (!$step1Data) {
            return redirect()->to(url_to('register.step1'))
                ->with('error', 'Session expirée, veuillez recommencer');
        }

        $rules = [
            'taille_cm'  => 'required|numeric|greater_than[50]|less_than[250]',
            'poids_kg'   => 'required|numeric|greater_than[20]|less_than[300]',
            'objectif_id' => 'required|numeric'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $db = \Config\Database::connect();
        try {
            $db->transStart();

            // 1. Créer l'utilisateur
            $userModel = new Utilisateur();
            $userData = [
                'nom'                => $step1Data['nom'],
                'prenom'             => $step1Data['prenom'],
                'email'              => $step1Data['email'],
                'mot_de_passe_hash'  => password_hash($step1Data['password'], PASSWORD_DEFAULT),
                'genre_id'           => $step1Data['genre_id'],
                'is_active'          => 1
            ];

            $userId = $userModel->insert($userData, true);

            // 2. Créer le profil de santé
            $taille = floatval($this->request->getPost('taille_cm'));
            $poids = floatval($this->request->getPost('poids_kg'));
            
            $imc = $poids / (($taille / 100) ** 2);

            $profilModel = new ProfilSante();
            $profilModel->insert([
                'utilisateur_id' => $userId,
                'taille_cm'      => $taille,
                'poids_kg'       => $poids,
                'imc'            => $imc,
                'objectif_id'    => $this->request->getPost('objectif_id'),
                'date_mesure'    => date('Y-m-d')
            ]);

            // 3. Créer le portefeuille initial
            $portefeuilleModel = new Portefeuille();
            $portefeuilleModel->insert([
                'utilisateur_id' => $userId,
                'solde'          => 0.00
            ]);

            $db->transComplete();

            if ($db->transStatus() === false) {
                throw new \Exception('Erreur lors de la création du compte');
            }

            // Nettoyer la session temporaire
            session()->removeTempdata('register_step1');

            // Connecter l'utilisateur automatiquement
            session()->set([
                'user_id' => $userId,
                'user_email' => $step1Data['email'],
                'user_name' => $step1Data['prenom'] . ' ' . $step1Data['nom'],
                'is_logged_in' => true,
                'is_admin' => false
            ]);

            return redirect()->to('/mon-espace')
                ->with('message', 'Compte créé avec succès! Bienvenue!');

        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->back()
                ->with('error', 'Erreur lors de la création du compte: ' . $e->getMessage());
        }
    }

    /**
     * Déconnexion utilisateur
     */
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/')->with('message', 'Vous avez été déconnecté');
    }

    /**
     * Page de login administrateur
     */
    public function adminLogout()
    {
        session()->destroy();
        return redirect()->to('/admin/login')->with('message', 'Vous avez été déconnecté');
    }
}
