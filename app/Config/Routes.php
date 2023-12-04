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
$routes->get("/start_application", "ApplicationController::viewStartApplication");
$routes->post("/application/submit", "ApplicationController::submitApplication");
$routes->get("/view_application", "ApplicationController::viewApplication");
$routes->get("/edit_application/(:num)", "ApplicationController::viewEditApplication/$1");
$routes->post("/application/update/(:num)", "ApplicationController::updateApplication/$1");
$routes->post("/application/delete/(:num)", "ApplicationController::deleteApplication/$1");
$routes->get("/add_program", "ProgramController::viewAddProgram");
$routes->post("/program/add", "ProgramController::addProgram");
$routes->get("/view_program", "ProgramController::viewProgram");
$routes->get("/edit_program/(:num)", "ProgramController::viewEditProgram/$1");
$routes->post("/program/update/(:num)", "ProgramController::updateProgram/$1");
$routes->post("/program/delete/(:num)", "ProgramController::deleteProgram/$1");
