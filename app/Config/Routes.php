<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/regime', 'Home::regime');
$routes->get('/admin/dashboard', 'Home::dashboard');
$routes->get('/admin/regime', 'Home::adminRegime');
$routes->get('/admin/sport', 'Home::adminSport');