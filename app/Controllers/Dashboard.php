<?php
// File: app/Controllers/Dashboard.php

namespace App\Controllers;

class Dashboard extends BaseController
{
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
