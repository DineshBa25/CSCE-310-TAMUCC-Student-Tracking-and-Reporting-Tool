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
                session()->set('UIN', $data['UIN']);
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

    public function register()
    {
        // Validation rules for registration form
        $validationRules = [
            'uin' => 'required|is_unique[Users.UIN]|exact_length[9]|numeric', // UIN must be unique, 9 digits, and numeric
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required|is_unique[Users.Username]',
            'password' => 'required|min_length[6]',
            'user_type' => 'required',
            'email' => 'required|valid_email|is_unique[Users.Email]',
            'discord_name' => 'required',
        ];

        if (!$this->validate($validationRules)) {
            // Validation failed, return with validation errors
            return redirect()->to('/register')->withInput()->with('validation', $this->validator);
        }

        // Get user input
        $data = [
            'UIN' => $this->request->getPost('uin'),
            'First_Name' => $this->request->getPost('first_name'),
            'Last_Name' => $this->request->getPost('last_name'),
            'Username' => $this->request->getPost('username'),
            'Passwords' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT), // Hash the password
            'User_Type' => $this->request->getPost('user_type'),
            'Email' => $this->request->getPost('email'),
            'Discord_Name' => $this->request->getPost('discord_name'),
            'IsActive' => 1, // Set IsActive to 1 for active users
        ];

        // Manually build the SQL query for insertion
        $sql = "INSERT INTO Users (UIN, First_Name, Last_Name, Username, Passwords, User_Type, Email, Discord_Name, IsActive) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // Get the values to insert
        $params = [
            $data['UIN'],
            $data['First_Name'],
            $data['Last_Name'],
            $data['Username'],
            $data['Passwords'],
            $data['User_Type'],
            $data['Email'],
            $data['Discord_Name'],
            $data['IsActive']
        ];

        // Execute the SQL query
        $db = \Config\Database::connect();
        $db->query($sql, $params);

        // Set a flash message for successful registration
        session()->setFlashdata('success', 'Registration successful. You can now login.');

        // Redirect to the login page
        return redirect()->to('/login');
    }
    public function registerPage()
    {
        return view('register'); // Load the 'register.php' view
    }
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
