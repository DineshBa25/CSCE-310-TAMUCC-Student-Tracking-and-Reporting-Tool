<?php

// File: app/Controllers/ProfileController.php

namespace App\Controllers;

class ProgramController extends BaseController
{
    public function viewAddProgram()
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login'); // Redirect to login if not logged in
        }

        // Assuming you have the user data stored in the session
        $userData = $this->userData;

        // Load the add program view
        return view('add_program', ['userData' => $userData]);
    }

    public function addProgram()
    {
        // check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login'); // Redirect to login if not logged in
        }

        // validate the form data
        $input = $this->validate([
            'program' => 'required',
            'description' => 'required',
            ]);

        // if validation fails, redirect back to the profile update form with errors
        if (!$input) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }


        // get the database connection
        $db = \Config\Database::connect();

        // insert the prpgram into the database Programs table
        $sql = "INSERT INTO Programs (Name, Description) VALUES (?, ?)";
        $db->query($sql, [$this->request->getVar('program'), $this->request->getVar('description')]);

        if ($db->affectedRows() == 1) {
            session()->setFlashdata('success', 'Program added successfully!');
        } else {
            session()->setFlashdata('error', 'Failed to add program.');
        }

        return redirect()->to('/add_program');
    }

    public function viewProgram()
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login'); // Redirect to login if not logged in
        }

        // Assuming you have the user data stored in the session
        $userData = $this->userData;

        // Get the user's ID from the session or other source
        $userId = session()->get('UIN'); // Ensure 'userId' is the correct session key that contains the UIN.

        // Get the database connection
        $db = \Config\Database::connect();

        // Fetch programs from the database
        $sql = "SELECT * FROM Programs";

        $query = $db->query($sql, [$userId]);

        $programs = $query->getResultArray();

        // If no programs exist handle it with an error message or set an empty array
        if (!$programs) {
            // Optionally set an error message if no data found
            session()->setFlashdata('error', 'No programs found.');
            return view('view_program', ['userData' => $userData, 'programs' => []]);
        }

        // Load student program view with programs
        return view('view_program', ['userData' => $userData, 'programs' => $programs]);
    }

    public function viewEditProgram($appNum = null)
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login'); // Redirect to login if not logged in
        }

        // Check if an program number has been provided
        if (!$appNum) {
            // Optionally set an error message if no program number is provided
            session()->setFlashdata('error', 'No program selected for editing.');
            return redirect()->to('/view_program'); // Redirect to the program listing page
        }

        // Assuming you have the user data stored in the session
        $userData = $this->userData;

        // Get the database connection
        $db = \Config\Database::connect();

        // Fetch the specific program along with the program name
        $sql = "SELECT * FROM Programs WHERE Program_Num = ?";

        $query = $db->query($sql, [$appNum]);

        $program = $query->getRowArray();

        // If the Program does not exist handle it with an error message
        if (!$program) {
            session()->setFlashdata('error', 'Program not found.');
            return redirect()->to('/view_program');
        }

        return view('edit_program', ['appNum' => $appNum, 'userData' => $userData, 'program' => $program]);
    }

    public function updateProgram($appNum = null)
    {

        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login'); // Redirect to login if not logged in
        }

        // Check if an program number has been provided
        if (!$appNum) {
            // Optionally set an error message if no program number is provided
            session()->setFlashdata('error', 'No program selected for updating.');
            return redirect()->to('/view_program'); // Redirect to the program listing page
        }

        // Validate the form data
        $input = $this->validate([
            'program' => 'required',
            'description' => 'required',
        ]);

        // If validation fails, redirect back to the profile update form with errors
        if (!$input) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        // Get the database connection
        $db = \Config\Database::connect();

        // Update the program in the database
        $sql = "UPDATE Programs SET Name = ?, Description = ? WHERE Program_Num = ?";
        $db->query($sql, [$this->request->getVar('program'), $this->request->getVar('description'), $appNum]);

        if ($db->affectedRows() == 1) {
            session()->setFlashdata('success', 'Program updated successfully!');
        } else {
            session()->setFlashdata('error', 'Program failed to update.');
        }

        return redirect()->to('/view_program');
    }

    public function deleteProgram($appNum = null)
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login'); // Redirect to login if not logged in
        }

        // Check if an program number has been provided
        if (!$appNum) {
            // Optionally set an error message if no program number is provided
            session()->setFlashdata('error', 'No Program selected for deletion.');
            return redirect()->to('/view_program'); // Redirect to the program listing page
        }

        // Get the database connection
        $db = \Config\Database::connect();

        // Delete the program from the database
        $sql = "DELETE FROM Programs WHERE Program_Num = ?";
        $db->query($sql, [$appNum]);

        if ($db->affectedRows() == 1) {
            session()->setFlashdata('success', 'Program deleted successfully!');
        } else {
            session()->setFlashdata('error', 'Program failed to delete.');
        }

        return redirect()->to('/view_program');
    }

}