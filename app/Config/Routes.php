<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/regime', 'Home::regime');
$routes->get('/sport', 'Home::sport');

// User Dashboard & Profil
$routes->get('/mon-espace', '\App\Controllers\Utilisateurs\FrontController::myDashboard');
$routes->post('/mon-profil/update', '\App\Controllers\Utilisateurs\ProfilSanteController::update/1');

$routes->group('admin', function($routes) {
    $routes->get('dashboard', 'Home::dashboard');
    $routes->get('regime', '\App\Controllers\Regimes\RegimeController::index');
    $routes->match(['get', 'post'], 'regime/create', '\App\Controllers\Regimes\RegimeController::create');
    $routes->match(['get', 'post'], 'regime/edit/(:num)', '\App\Controllers\Regimes\RegimeController::edit/$1');
    $routes->get('regime/delete/(:num)', '\App\Controllers\Regimes\RegimeController::destroy/$1');
    
    $routes->get('sport', '\App\Controllers\Activites\ActiviteController::index');
    $routes->match(['get', 'post'], 'sport/create', '\App\Controllers\Activites\ActiviteController::create');
    $routes->match(['get', 'post'], 'sport/edit/(:num)', '\App\Controllers\Activites\ActiviteController::edit/$1');
    $routes->get('sport/delete/(:num)', '\App\Controllers\Activites\ActiviteController::destroy/$1');
});
$routes->get('/admin/sport', 'Home::adminSport');
// Portefeuille Recharge
$routes->post('portefeuille/recharger', '\App\Controllers\Portefeuilles\CodePortefeuilleController::utiliser');

// Achat Programme
$routes->post('commande/acheter-programme', '\App\Controllers\Commandes\CommandeController::acheterProgramme');

// Abonnement Gold
$routes->get('mon-espace/devenir-gold', '\App\Controllers\Utilisateurs\FrontController::devenirGold');
$routes->post('mon-espace/souscrire-gold', '\App\Controllers\Utilisateurs\FrontController::souscrireGold');
