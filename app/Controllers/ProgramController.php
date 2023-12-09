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

    public function deactivateProgram($programNum = null)
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login'); // Redirect to login if not logged in
        }

        // Check if a program number has been provided
        if (!$programNum) {
            session()->setFlashdata('error', 'No program selected for deactivation.');
            return redirect()->to('/view_program'); // Redirect to the program listing page
        }

        // Get the database connection
        $db = \Config\Database::connect();

        // Deactivate the program in the database
        $sql = "UPDATE Programs SET IsActive = 0 WHERE Program_Num = ?";
        $db->query($sql, [$programNum]);

        if ($db->affectedRows() > 0) {
            session()->setFlashdata('success', 'Program deactivated successfully!');
        } else {
            session()->setFlashdata('error', 'Failed to deactivate program.');
        }

        return redirect()->to('/view_program');
    }

    public function activateProgram($programNum = null)
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login'); // Redirect to login if not logged in
        }

        // Check if a program number has been provided
        if (!$programNum) {
            session()->setFlashdata('error', 'No program selected for activation.');
            return redirect()->to('/view_program'); // Redirect to the program listing page
        }

        // Get the database connection
        $db = \Config\Database::connect();

        // Activate the program in the database
        $sql = "UPDATE Programs SET IsActive = 1 WHERE Program_Num = ?";
        $db->query($sql, [$programNum]);

        if ($db->affectedRows() > 0) {
            session()->setFlashdata('success', 'Program activated successfully!');
        } else {
            session()->setFlashdata('error', 'Failed to activate program.');
        }

        return redirect()->to('/view_program');
    }

    public function viewProgramReport($programNum)
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        // Get the database connection
        $db = \Config\Database::connect();

        // Fetch the program's name
        $programNameQuery = $db->query("SELECT Name FROM Programs WHERE Program_Num = ?", [$programNum]);
        $programNameRow = $programNameQuery->getRowArray();
        $programName = $programNameRow['Name'] ?? 'Unknown Program';

        // Assuming you have methods to get the required data
        $totalStudents = $this->getTotalEnrollmentByProgram($db, $programNum);
        $minorityStudents = $this->getMinorityParticipationByProgram($db, $programNum);
        $k12Students = $this->getK12ParticipationByProgram($db, $programNum);
        $studentMajors = $this->getStudentMajorsByProgram($db, $programNum);

        // Prepare report data array
        $reportData = [
            'ProgramName' => $programName,
            'TotalStudents' => $totalStudents,
            'MinorityStudents' => $minorityStudents,
            'K12Students' => $k12Students,
            'Majors' => $studentMajors,
        ];

        $userData = $this->userData;

        // Load the program report view with report data
        return view('program_report', ['userData' => $userData, 'reportData' => $reportData]);
    }
  
    // Example method to get the total enrollment by program
    private function getTotalEnrollmentByProgram($db, $programNum) {
        // Replace with your actual SQL query and parameters
        $sql = "SELECT COUNT(*) AS count FROM Track WHERE Program_Num = ?";
        $query = $db->query($sql, [$programNum]);
        return $query->getRowArray()['count'];
    }

    private function getMinorityParticipationByProgram($db, $programNum) {
        $sql = "SELECT COUNT(*) AS count FROM College_Student 
            JOIN Track ON College_Student.UIN = Track.UIN
            WHERE Track.Program_Num = ? AND College_Student.Race != 'White'";
        $query = $db->query($sql, [$programNum]);
        return $query->getRowArray()['count'];
    }

    private function getK12ParticipationByProgram($db, $programNum) {
        $sql = "SELECT COUNT(*) AS count FROM College_Student 
            JOIN Track ON College_Student.UIN = Track.UIN
            WHERE Track.Program_Num = ? AND College_Student.Classification = 'K-12'";
        $query = $db->query($sql, [$programNum]);
        return $query->getRowArray()['count'];

    }

    private function getStudentMajorsByProgram($db, $programNum) {
        $sql = "SELECT College_Student.Major, COUNT(*) AS count FROM College_Student 
            JOIN Track ON College_Student.UIN = Track.UIN
            WHERE Track.Program_Num = ?
            GROUP BY College_Student.Major";
        $query = $db->query($sql, [$programNum]);
        $majors = [];
        foreach ($query->getResultArray() as $row) {
            $majors[$row['Major']] = $row['count'];
        }
        return $majors;
    }


}