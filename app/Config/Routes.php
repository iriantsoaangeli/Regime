<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ============================================================
// PUBLIC ROUTES (No Auth Required)
// ============================================================
$routes->get('/', 'Home::index');
$routes->get('/regime', 'Home::regime');
$routes->get('/sport', 'Home::sport');

// ============================================================
// AUTHENTICATION ROUTES
// ============================================================
$routes->get('/login', '\App\Controllers\Auth\AuthController::loginPage', ['as' => 'login']);
$routes->post('/login', '\App\Controllers\Auth\AuthController::loginSubmit');

$routes->get('/register/step1', '\App\Controllers\Auth\AuthController::registerStep1', ['as' => 'register.step1']);
$routes->post('/register/step1', '\App\Controllers\Auth\AuthController::registerStep1Submit', ['as' => 'register.step1.submit']);

$routes->get('/register/step2', '\App\Controllers\Auth\AuthController::registerStep2', ['as' => 'register.step2']);
$routes->post('/register/step2', '\App\Controllers\Auth\AuthController::registerStep2Submit', ['as' => 'register.step2.submit']);

$routes->get('/logout', '\App\Controllers\Auth\AuthController::logout');

// Admin Auth
$routes->get('/admin/login', '\App\Controllers\Auth\AdminAuthController::loginForm', ['as' => 'admin.login']);
$routes->post('/admin/login', '\App\Controllers\Auth\AdminAuthController::login', ['as' => 'admin.login.submit']);
$routes->get('/admin/logout', '\App\Controllers\Auth\AdminAuthController::logout');

// ============================================================
// PROTECTED USER ROUTES (AuthFilter)
// ============================================================
$routes->group('', ['filter' => 'AuthFilter'], function($routes) {
    $routes->get('/mon-espace', '\App\Controllers\Utilisateurs\FrontController::myDashboard');
    $routes->post('/mon-profil/update', '\App\Controllers\Utilisateurs\ProfilSanteController::update/1');
    
    // Portefeuille Recharge
    $routes->post('portefeuille/recharger', '\App\Controllers\Portefeuilles\CodePortefeuilleController::utiliser');
    
    // Achat Programme
    $routes->post('commande/acheter-programme', '\App\Controllers\Commandes\CommandeController::acheterProgramme');
    
    // Abonnement Gold
    $routes->get('mon-espace/devenir-gold', '\App\Controllers\Utilisateurs\FrontController::devenirGold');
    $routes->post('mon-espace/souscrire-gold', '\App\Controllers\Utilisateurs\FrontController::souscrireGold');
});

// ============================================================
// PROTECTED ADMIN ROUTES (AdminFilter)
// ============================================================
$routes->group('admin', ['filter' => 'AdminFilter'], function($routes) {
    $routes->get('dashboard', 'Home::dashboard');
    $routes->get('regime', '\App\Controllers\Regimes\RegimeController::index');
    $routes->match(['GET', 'POST'], 'regime/create', '\App\Controllers\Regimes\RegimeController::create');
    $routes->match(['GET', 'POST'], 'regime/edit/(:num)', '\App\Controllers\Regimes\RegimeController::edit/$1');
    $routes->get('regime/delete/(:num)', '\App\Controllers\Regimes\RegimeController::destroy/$1');
    
    $routes->get('sport', '\App\Controllers\Activites\ActiviteController::index');
    $routes->match(['GET', 'POST'], 'sport/create', '\App\Controllers\Activites\ActiviteController::create');
    $routes->match(['GET', 'POST'], 'sport/edit/(:num)', '\App\Controllers\Activites\ActiviteController::edit/$1');
    $routes->get('sport/delete/(:num)', '\App\Controllers\Activites\ActiviteController::destroy/$1');
});

