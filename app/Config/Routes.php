<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('login', 'Login::index');
$routes->post('login/authenticate', 'Login::authenticate');
$routes->get('dashboard', 'Dashboard::index');
$routes->get('logout', 'Login::logout');
$routes->get('profile/update', 'ProfileController::viewUpdateProfile');
$routes->post('/profile/update_process', 'ProfileController::updateProfileProcess');
$routes->post('/profile/deactivate', 'ProfileController::deactivateAccount');
$routes->post('/profile/delete', 'ProfileController::permenantlyDeleteAccount');
$routes->get('/register', 'Login::registerPage');
$routes->post('/registration/process', 'Login::register');

