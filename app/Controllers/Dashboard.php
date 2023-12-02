<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Dashboard extends Controller
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login'); // Redirect to login if not logged in
        }

        $session = session();
        $model = new \App\Models\UserModel();

        // Assuming you have the username stored in the session or request
        $username = $session->get('username');

        // Fetch user data
        $userData = $model->where('username', $username)->first();

        // Pass user data to the view
        return view('dashboard', ['userData' => $userData]);

    }
}
