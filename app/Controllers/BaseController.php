<?php
// File: app/Controllers/BaseController.php

namespace App\Controllers;

use CodeIgniter\Controller;

class BaseController extends Controller
{
    protected $userData; // Declare a property to hold user data

    /**
     * Initializes the controller by setting the request, response, and logger objects.
     *
     * @param \CodeIgniter\HTTP\RequestInterface $request The request object.
     * @param \CodeIgniter\HTTP\ResponseInterface $response The response object.
     * @param \Psr\Log\LoggerInterface $logger The logger object.
     *
     * @return void
     */
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Check if user is logged in
        if (session()->get('isLoggedIn')) {
            // Assuming you have the username stored in the session or request
            $username = session()->get('username');

            // Fetch user data and store it in the property
            $model = new \App\Models\UserModel();
            $this->userData = $model->where('username', $username)->first();
        }
    }
}

