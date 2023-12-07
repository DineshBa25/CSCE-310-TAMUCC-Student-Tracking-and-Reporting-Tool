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
<<<<<<< Updated upstream
=======
    public function searchStudentData()
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

        // // Get the user's ID from the session or other source
        $userId = session()->get('userId'); // Ensure 'userId' is the correct session key that contains the UIN.

        // // Get the database connection
        $db = \Config\Database::connect();

        $params = [
            $uin = $this->request->getPost('uin'),
            $fname = $this->request->getPost('first_name'),
            $lname = $this->request->getPost('last_name'),

            $userId // The WHERE clause value
        ];

        if(!empty($uin)){
            $sql = "SELECT UIN FROM `sitedb`.`College_Student` WHERE UIN = ?";
            $search = $db->query($sql, [$uin]);
            $pulled_vals = $search->getRowArray();

            if (!$pulled_vals) {
                $pulled_vals = [];
                session()->setFlashdata('error', 'No student data found.');
                return view("Progress_Search");
                }
        
        }

        if(!empty($fname) AND !empty($lname)){
            $sql = "SELECT * FROM sitedb.Users WHERE User_Type = 'Student' AND First_Name = ? AND Last_Name = ?";
            $search = $db->query($sql, [$fname,$lname]);
            $pulled_vals = $search->getRowArray();

            if (!$pulled_vals) {
                $pulled_vals = [];
                session()->setFlashdata('error', 'No student data found.');
                return view("Progress_Search");
                }
            return view('view_students', ['userData' => $userData, 'names' => $pulled_vals]);
        }


        $input = $this->validate([
            'first_name' => 'required|alpha_space',
            'm_initial' => 'permit_empty|alpha',
            'last_name' => 'required|alpha_space',
            'email' => 'required|valid_email',
            // add validation rules for other fields as needed
        ]);
        

        // // Fetch student data from the College_Student table
        if($userId != $userData['']) {
        $sql = "SELECT UIN FROM `sitedb`.`College_Student` WHERE UIN = '';";
        $query = $db->query($sql, [$userId]);
        $all_named = $query->getRowArray();

        if (!$all_named) {
            $studentData = [];
            // Optionally set an error message if no data found
            // session()->setFlashdata('error', 'No student data found.');
            }
        }

        // // Load the dashboard view with both user and student data
        return view("Progress_Search", ['userData' => $userData]);
    }
>>>>>>> Stashed changes


    /**
     * @throws \ReflectionException
     */
}