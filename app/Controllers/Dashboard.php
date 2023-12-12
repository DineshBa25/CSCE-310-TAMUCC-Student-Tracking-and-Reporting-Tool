<?php
// File: app/Controllers/Dashboard.php

namespace App\Controllers;

/**
 * Class Dashboard
 *
 * This class represents the dashboard controller in the application.
 * It extends the BaseController class.
 */
class Dashboard extends BaseController
{
    /**
     * Index method.
     *
     * This method checks if a user is logged in and redirects them to the login page if not.
     * It then retrieves user data from the BaseController and loads the dashboard view.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse|string If the user is not logged in, a redirect response to the login page is returned. Otherwise, the dashboard view is returned as a string
     *.
     */
    public function index()
    {
        // Check if user is logged in

        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login'); // Redirect to login if not logged in
        }

        // Access the $userData property from the BaseController
        $userData = $this->userData;

        // You can now use $userData in this controller

        // Load the dashboard view
        return view('dashboard', ['userData' => $userData]);
    }
}
