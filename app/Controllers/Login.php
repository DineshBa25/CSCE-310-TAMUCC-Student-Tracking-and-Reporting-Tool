<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Login extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function authenticate()
    {
        $session = session();
        $model = new \App\Models\UserModel();
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        // Temporary login validation without database
        // Here, you can specify a hardcoded username and password
        $hardcodedUsername = 'testuser';
        $hardcodedPassword = 'testpass';

        if ($username == $hardcodedUsername && $password == $hardcodedPassword) {
            // If credentials match, set session data
            $ses_data = [
                'username' => $hardcodedUsername,
                'isLoggedIn' => TRUE
            ];
            $session->set($ses_data);
            return redirect()->to('/dashboard'); // Redirect to the dashboard
        } else {
            // If credentials do not match, set error message
            $session->setFlashdata('msg', 'Incorrect Username or Password');
            return redirect()->to('/login'); // Redirect back to the login page
        }

//        $data = $model->where('username', $username)->first();
//
//        if ($data) {
//            $pass = $data['password'];
//            $authenticatePassword = password_verify($password, $pass);
//            if ($authenticatePassword) {
//                $ses_data = [
//                    'username' => $data['username'],
//                    'isLoggedIn' => TRUE
//                ];
//                $session->set($ses_data);
//                return redirect()->to('/dashboard');
//            } else {
//                $session->setFlashdata('msg', 'Wrong Password');
//                return redirect()->to('/login');
//            }
//        } else {
//            $session->setFlashdata('msg', 'Username does not exist');
//            return redirect()->to('/login');
//        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

}
