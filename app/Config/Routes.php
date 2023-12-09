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

$routes->get("/create_event", "EventController::viewCreateEvent");
$routes->post("/event/create", "EventController::submitEvent");
$routes->get("/view_event", "EventController::viewEvent");
$routes->get("/edit_event/(:num)", "EventController::viewEditEvent/$1");
$routes->post("/event/update/(:num)", "EventController::updateEvent/$1");
$routes->post("/event/delete/(:num)", "EventController::deleteEvent/$1");

$routes->get("/view_event_tracking", "EventController::viewEventTracking");
$routes->get("/edit_event_tracking/(:num)", "EventController::viewEditEventTracking/$1");
$routes->post("/eventtracking/update/(:num)", "EventController::updateEventTracking/$1");
$routes->post("/eventtracking/delete/(:num)", "EventController::deleteEventTracking/$1");

$routes->post("/application/submit", "ApplicationController::submitApplication");
$routes->get("/view_application", "ApplicationController::viewApplication");
$routes->get("/edit_application/(:num)", "ApplicationController::viewEditApplication/$1");
$routes->post("/application/update/(:num)", "ApplicationController::updateApplication/$1");
$routes->post("/application/delete/(:num)", "ApplicationController::deleteApplication/$1");
$routes->get("/add_program", "ProgramController::viewAddProgram");
$routes->post("/program/add", "ProgramController::addProgram");
$routes->get("/view_program", "ProgramController::viewProgram");
$routes->get("/edit_program/(:num)", "ProgramController::viewEditProgram/$1");
$routes->get("/program_report/(:num)", "ProgramController::viewProgramReport/$1");
$routes->post("/program/update/(:num)", "ProgramController::updateProgram/$1");
$routes->post("/program/delete/(:num)", "ProgramController::deleteProgram/$1");
$routes->post("/program/deactivate/(:num)", "ProgramController::deactivateProgram/$1");
$routes->post("/program/activate/(:num)", "ProgramController::activateProgram/$1");
$routes->get("/reports", "ReportsController::viewReportsDashboard/$1");
$routes->get("/add_file", "FileUploadController::viewAddFile");
$routes->post("/file/add", "FileUploadController::addFile");
$routes->get("/view_file", "FileUploadController::viewFile");
$routes->get("/edit_file/(:num)", "FileUploadController::viewEditFile/$1");
$routes->post("/file/update/(:num)", "FileUploadController::updateFile/$1");
$routes->post("/file/delete/(:num)", "FileUploadController::deleteFile/$1");
$routes->get("/add_user", "AdminUserController::viewAddUser");
$routes->post("/user/add", "AdminUserController::addUser");
$routes->get("/view_users", "AdminUserController::viewUsers");
$routes->get("/edit_user/(:num)", "AdminUserController::viewEditUser/$1");
$routes->post("/user/update/(:num)", "AdminUserController::updateUser/$1");
$routes->post("/user/delete/(:num)", "AdminUserController::deleteUser/$1");
$routes->post("/user/deactivate/(:num)", "AdminUserController::deactivateUser/$1");
$routes->post("/user/activate/(:num)", "AdminUserController::activateUser/$1");
$routes->get("/reset_password", "Login::viewResetPassword");
$routes->post("/password/reset", "Login::resetPassword");
$routes->get('/reports/viewReportsDashboard', 'ReportsController::viewReportsDashboard');
