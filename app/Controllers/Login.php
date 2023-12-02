<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel; // Import the UserModel

class Login extends Controller
{
    // Declare a private property to hold the UserModel instance
    private $userModel;

    public function __construct()
    {
        // Initialize the UserModel instance in the constructor
        $this->userModel = new UserModel();
    }

    public function index()
    {
        return view('login');
    }

    public function authenticate()
    {
        $session = session();
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        // Retrieve user data from the UserModel
        $data = $this->userModel->where('username', $username)->first();

        if ($data) {
            $pass = $data['Passwords'];
            $authenticatePassword = password_verify($password, $pass);
            //log password
            if ($authenticatePassword) {
                $ses_data = [
                    'username' => $data['Username'],
                    'isLoggedIn' => TRUE
                ];
                $session->set($ses_data);
                return redirect()->to('/dashboard');
            } else {
                $session->setFlashdata('msg', 'Wrong Password');
                return redirect()->to('/login');
            }
        } else {
            $session->setFlashdata('msg', 'Username does not exist');
            return redirect()->to('/login');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
