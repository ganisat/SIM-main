<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');
$routes->get('/', 'UserController::login');
$routes->post('/loginAuth', 'UserController::loginAuth');
$routes->get('/dashboard', 'UserController::dashboard', ['filter' => 'auth']);
$routes->get('/logout', 'UserController::logout');
 