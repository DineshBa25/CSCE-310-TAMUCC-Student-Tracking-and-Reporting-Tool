<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'Users'; // Your user table name
    protected $primaryKey = 'UIN';
    protected $allowedFields = ['Username', 'Passwords', 'Email', 'First_Name', 'Last_Name'];

    // Validation rules and messages as previously defined...

    // Method to retrieve user data by username
    public function getUserByUsername($username)
    {
        return $this->where('username', $username)->first();
    }

    // Method to verify user login
    public function verifyLogin($username, $password)
    {
        // Retrieve user data by username
        $user = $this->getUserByUsername($username);

        // If the user exists
        if ($user) {
            // Verify the provided password against the hashed password in the database
            if (password_verify($password, $user['Passwords'])) {
                return $user; // Return user data if login is successful
            }
        }

        return null; // Return null if login fails
    }
}
