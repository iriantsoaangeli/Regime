<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\Home;
use App\Controllers\Auth\AuthController;
use App\Controllers\Auth\AdminAuthController;
use App\Controllers\Utilisateurs\FrontController;
use App\Controllers\Utilisateurs\ProfilSanteController;
use App\Controllers\Portefeuilles\CodePortefeuilleController;
use App\Controllers\Commandes\CommandeController;
use App\Controllers\Regimes\RegimeController;
use App\Controllers\Activites\ActiviteController;
use App\Controllers\Utilisateurs\UtilisateurController;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'UtilisateurController::home');


// ============================================================
// AUTHENTICATION ROUTES
// ============================================================

$routes->get('/accueil', 'UtilisateurController::home');

$routes->get('/regime', 'Home::regime');
$routes->get('/sport', 'Home::sport');

$routes->get('/login', 'AuthController::loginPage', ['as' => 'login']);
$routes->post('/login', 'AuthController::loginSubmit');

$routes->get('/register/step1', 'AuthController::registerStep1', ['as' => 'register.step1']);
$routes->post('/register/step1', 'AuthController::registerStep1Submit', ['as' => 'register.step1.submit']);

$routes->get('/register/step2', 'AuthController::registerStep2', ['as' => 'register.step2']);
$routes->post('/register/step2', 'AuthController::registerStep2Submit', ['as' => 'register.step2.submit']);

$routes->get('/logout', 'AuthController::logout');

// Admin Auth
$routes->get('/admin/login', 'AdminAuthController::loginForm', ['as' => 'admin.login']);
$routes->post('/admin/login', 'AdminAuthController::login', ['as' => 'admin.login.submit']);
$routes->get('/admin/logout', 'AdminAuthController::logout');

// ============================================================
// PROTECTED USER ROUTES (AuthFilter)
// ============================================================
$routes->group('', ['filter' => 'AuthFilter'], function ($routes) {
    $routes->get('/mon-espace', 'FrontController::myDashboard');
    $routes->post('/mon-profil/update', 'ProfilSanteController::update/1');

    // Portefeuille Recharge
    $routes->post('portefeuille/recharger', 'CodePortefeuilleController::utiliser');

    // Achat Programme
    $routes->post('commande/acheter-programme', 'CommandeController::acheterProgramme');

    // Abonnement Gold
    $routes->get('mon-espace/devenir-gold', 'FrontController::devenirGold');
    $routes->post('mon-espace/souscrire-gold', 'FrontController::souscrireGold');
});

// ============================================================
// PROTECTED ADMIN ROUTES (AdminFilter)
// ============================================================
$routes->group('admin', ['filter' => 'AdminFilter'], function ($routes) {
    $routes->get('dashboard', 'Home::dashboard');
    $routes->get('regime', 'RegimeController::index');
    $routes->match(['GET', 'POST'], 'regime/create', 'RegimeController::create');
    $routes->match(['GET', 'POST'], 'regime/edit/(:num)', 'RegimeController::edit/$1');
    $routes->get('regime/delete/(:num)', 'RegimeController::destroy/$1');

    $routes->get('sport', 'ActiviteController::index');
    $routes->match(['GET', 'POST'], 'sport/create', 'ActiviteController::create');
    $routes->match(['GET', 'POST'], 'sport/edit/(:num)', 'ActiviteController::edit/$1');
    $routes->get('sport/delete/(:num)', 'ActiviteController::destroy/$1');
});

