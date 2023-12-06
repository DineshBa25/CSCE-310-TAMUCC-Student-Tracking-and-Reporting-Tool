<?php
// File: app/Controllers/ProgressSearchController.php

namespace App\Controllers;

class ProgressSearchController extends BaseController
{
    public function mainProgressPage()
    {
        $userData = $this->userData;
        //Check if user is logged in;lde'[2cdsx12]
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login'); // Redirect to login if not logged in
        }

        // Verify that the user is an admin:
        
        $userData = $this->userData;       
        if($userData['User_Type'] != 'Administrator') {
            return redirect()->to('/dashboard');
        }

        // // Assuming you have the user data stored in the session
        // $userData = $this->userData;

        // // Get the user's ID from the session or other source
        // $userId = session()->get('userId'); // Ensure 'userId' is the correct session key that contains the UIN.

        // // Get the database connection
        // $db = \Config\Database::connect();

        // // Fetch student data from the College_Student table
        // $sql = "SELECT * FROM College_Student WHERE UIN = 123001234";
        // $query = $db->query($sql, [$userId]);
        // $studentData = $query->getRowArray();

        // // If student data is not found, you can handle it with an error message or set an empty array
        // if (!$studentData) {
        //     $studentData = [];
        //     // Optionally set an error message if no data found
        //     // session()->setFlashdata('error', 'No student data found.');
        // }

        // // Load the dashboard view with both user and student data
        return view("Progress_Search", ['userData' => $userData]);
    }


    /**
     * @throws \ReflectionException
     */
}