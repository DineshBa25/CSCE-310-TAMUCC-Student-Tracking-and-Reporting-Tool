<?php
// File: app/Controllers/UserViewComposer.php

namespace App\Controllers;

use App\Models\UserModel;

class UserViewComposer
{
    public static function compose(\CodeIgniter\View\View $view)
    {
        // Check if the user is logged in
        if (session()->get('isLoggedIn')) {
            // Fetch user data and pass it to the view
            $username = session()->get('username');
            $model = new UserModel();
            $userData = $model->where('username', $username)->first();
            $view->setVar('userData', $userData);
        }
    }
}
