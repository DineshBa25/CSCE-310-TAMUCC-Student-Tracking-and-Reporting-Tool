<?php

namespace App\Controllers;

class ReportsController extends BaseController
{
    public function viewReportsDashboard()
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login'); // Redirect to login if not logged in
        }

        // Assuming you have the user data stored in the session
        $userData = $this->userData;

        // Load the add program view
        return view('reports', ['userData' => $userData]);
    }
}
