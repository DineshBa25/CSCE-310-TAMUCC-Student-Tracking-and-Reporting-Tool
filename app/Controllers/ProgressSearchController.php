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
            $sql = "SELECT * FROM sitedb.College_Student WHERE UIN = ?";
            $search = $db->query($sql, [$uin]);
            $pulled_vals = $search->getRowArray();

            if (!$pulled_vals) {
                $pulled_vals = [];
                session()->setFlashdata('error', 'No student data found.');
                return view("Progress_Search", ['userData' => $userData]);
            }
            $_SESSION['uin'] = $uin;
            return redirect()->to('/progress_tracking/goto');
        }

        if(!empty($fname) AND !empty($lname)){
            $sql = "SELECT * FROM sitedb.Users WHERE User_Type = 'Student' AND First_Name = ? AND Last_Name = ?";
            $search = $db->query($sql, [$fname,$lname]);
            $pulled_vals = $search->getResultArray();

            if (!$pulled_vals) {
                $pulled_vals = [];
                session()->setFlashdata('error', 'No student data found.');
                return view("Progress_Search", ['userData' => $userData]);
                }
            return view('view_students', ['userData' => $userData, 'pulled_vals' => $pulled_vals]);
        }
        // GOTO init:
        return view("Progress_Search", ['userData' => $userData]);
    }
    public function searchUIN()
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

        if(empty($_POST['uin']) AND empty($_SESSION['uin'])){
            session()->setFlashdata('error', "no user found");
            return view("Progress_Search", ['userData' => $userData]);
        }
        if(empty($_SESSION['uin'])){
            $uin = $_POST['uin'];
        }
        if(empty($_POST['uin'])){
            $uin = $_SESSION['uin'];
        }
        // // Get the user's ID from the session or other source
        $userId = session()->get('userId'); // Ensure 'userId' is the correct session key that contains the UIN.

        // // Get the database connection
        $db = \Config\Database::connect();

        $params = [
            $userId // The WHERE clause value
        ];

        $sql = "SELECT * FROM sitedb.Class_Enrollment WHERE UIN = ?";
        $search = $db->query($sql, [$uin]);
        $pulled_vals = $search->getResultArray();

        $sql = "SELECT * FROM sitedb.Intern_App WHERE UIN = ?";
        $search = $db->query($sql, [$uin]);
        $pulled_intern = $search->getResultArray();

        $sql = "SELECT * FROM sitedb.Cert_Enrollment WHERE UIN = ?";
        $search = $db->query($sql, [$uin]);
        $pulled_enroll = $search->getResultArray();


        return view("tracker_page", ['userData' => $userData, 'pulled_vals' => $pulled_vals, 'pulled_intern' => $pulled_intern, 'pulled_enroll' => $pulled_enroll]);
    }
    


    /**
     * @throws \ReflectionException
     */
}