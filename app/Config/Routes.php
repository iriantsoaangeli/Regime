<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Utilisateurs\UtilisateurController::home');


// ============================================================
// AUTHENTICATION ROUTES
// ============================================================

$routes->get('/accueil', 'Utilisateurs\UtilisateurController::home');

$routes->get('/regime', 'Home::regime');
$routes->get('/sport', 'Home::sport');

$routes->get('/login', 'Auth\AuthController::loginPage', ['as' => 'login']);
$routes->post('/login', 'Auth\AuthController::loginSubmit');

$routes->get('/register/step1', 'Auth\AuthController::registerStep1', ['as' => 'register.step1']);
$routes->post('/register/step1', 'Auth\AuthController::registerStep1Submit', ['as' => 'register.step1.submit']);

$routes->get('/register/step2', 'Auth\AuthController::registerStep2', ['as' => 'register.step2']);
$routes->post('/register/step2', 'Auth\AuthController::registerStep2Submit', ['as' => 'register.step2.submit']);

$routes->get('/logout', 'Auth\AuthController::logout');

// Admin Auth
$routes->get('/admin/login', 'Auth\AdminAuthController::loginForm', ['as' => 'admin.login']);
$routes->post('/admin/login', 'Auth\AdminAuthController::login', ['as' => 'admin.login.submit']);
$routes->get('/admin/logout', 'Auth\AdminAuthController::logout');

// ============================================================
// PROTECTED USER ROUTES (AuthFilter)
// ============================================================
$routes->group('', ['filter' => 'AuthFilter'], function ($routes) {
    $routes->get('/mon-espace', 'Utilisateurs\FrontController::myDashboard');
    $routes->post('/mon-profil/update', 'Utilisateurs\ProfilSanteController::update/1');

    // Portefeuille Recharge
    $routes->post('portefeuille/recharger', 'Portefeuilles\CodePortefeuilleController::utiliser');

    // Achat Programme
    $routes->post('commande/acheter-programme', 'Commandes\CommandeController::acheterProgramme');

    // Abonnement Gold
    $routes->get('mon-espace/devenir-gold', 'Utilisateurs\FrontController::devenirGold');
    $routes->post('mon-espace/souscrire-gold', 'Utilisateurs\FrontController::souscrireGold');
});

// ============================================================
// PROTECTED ADMIN ROUTES (AdminFilter)
// ============================================================
$routes->group('admin', ['filter' => 'AdminFilter'], function ($routes) {
    $routes->get('dashboard', 'Home::dashboard');
    $routes->get('regime', 'Regimes\RegimeController::index');
    $routes->match(['GET', 'POST'], 'regime/create', 'Regimes\RegimeController::create');
    $routes->match(['GET', 'POST'], 'regime/edit/(:num)', 'Regimes\RegimeController::edit/$1');
    $routes->get('regime/delete/(:num)', 'Regimes\RegimeController::destroy/$1');

    $routes->get('sport', 'Activites\ActiviteController::index');
    $routes->match(['GET', 'POST'], 'sport/create', 'Activites\ActiviteController::create');
    $routes->match(['GET', 'POST'], 'sport/edit/(:num)', 'Activites\ActiviteController::edit/$1');
    $routes->get('sport/delete/(:num)', 'Activites\ActiviteController::destroy/$1');
});

