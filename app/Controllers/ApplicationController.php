<?php
// File: app/Controllers/ProfileController.php

namespace App\Controllers;

/**
 * Class ApplicationController
 *
 * This class handles the application related functionality such as viewing, submitting, editing and updating applications.
 *
 * @package Your\Namespace
 */
class ApplicationController extends BaseController
{
    /**
     * Retrieves the start application view with user data and active programs.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse|string The start application view with user data and active programs, or a redirect to the login page if the user is not logged in.
     */
    public function viewStartApplication()
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login'); // Redirect to login if not logged in
        }

        // Assuming you have the user data stored in the session
        $userData = $this->userData;

        // Get the user's ID from the session or other source
        $userId = session()->get('userId'); // Ensure 'userId' is the correct session key that contains the UIN.

        // Get the database connection
        $db = \Config\Database::connect();

        // Fetch student data from the College_Student table
        $sql = "SELECT * FROM Programs WHERE IsActive = 1";

        $query = $db->query($sql);

        $programs = $query->getResultArray();

        // If no programs exist handle it with an error message or set an empty array
        if (!$programs) {
            $programs = [];
            // Optionally set an error message if no data found
            session()->setFlashdata('error', 'No student data found.');
        }

        //Load student application view with programs
        return view('start_application', ['userData' => $userData, 'programs' => $programs]);

    }

    /**
     * Submits the application form data to create a new application in the database.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse|string Redirects to the start application page or displays an error message if the application failed to submit.
     */
    public function submitApplication()
    {
        // check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login'); // Redirect to login if not logged in
        }

        // validate the form data
        $input = $this->validate([
            'program' => 'required',
            'uin' => 'required|numeric',
            'certifications' => 'required',
            'uncompleted_certifications' => 'required',
            'purpose_statement' => 'required'
        ]);

        // if validation fails, redirect back to the profile update form with errors
        if (!$input) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        // get the user's ID from the session or other source
        $userId = session()->get('UIN');

        // get the database connection
        $db = \Config\Database::connect();

        // insert the application into the database
        $sql = "INSERT INTO Applications (Program_Num, UIN, Uncom_Cert, Com_Cert, Purpose_Statement) VALUES (?, ?, ?, ?, ?)";
        $db->query($sql, [$this->request->getVar('program'), $this->request->getVar('uin'), $this->request->getVar('uncompleted_certifications'), $this->request->getVar('certifications'), $this->request->getVar('purpose_statement')]);

        if($db->affectedRows() == 1){
            session()->setFlashdata('success', 'Application submitted successfully!');
        } else {
            session()->setFlashdata('error', 'Application failed to submit.');
        }

        return redirect()->to('/start_application');
    }

    /**
     * Retrieves the view application view with user data and applications.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse|string The view application view with user data and applications, or a redirect to the login page if the user is not logged in.
     */
    public function viewApplication()
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

        // Fetch student applications along with program names
        $sql = "SELECT a.*, p.Name AS Program_Name 
            FROM Applications a
            JOIN Programs p ON a.Program_Num = p.Program_Num
            WHERE a.UIN = ?";

        $query = $db->query($sql, [$userId]);

        $applications = $query->getResultArray();

        // If no applications exist handle it with an error message or set an empty array
        if (!$applications) {
            // Optionally set an error message if no data found
            session()->setFlashdata('error', 'No applications found.');
            return view('view_application', ['userData' => $userData, 'applications' => []]);
        }

        // Load student application view with programs
        return view('view_application', ['userData' => $userData, 'applications' => $applications]);
    }

    /**
     * Retrieves the edit application view with user data, application data, and available programs.
     *
     * @param string|null $appNum The application number to be edited.
     * @return \CodeIgniter\HTTP\RedirectResponse|string The edit application view with user data, application data, and available programs, or a redirect to the login page if the user is
     * not logged in or to the application listing page if no application number is provided or if the application is not found.
     */
    public function viewEditApplication($appNum = null)
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login'); // Redirect to login if not logged in
        }

        // Check if an application number has been provided
        if (!$appNum) {
            // Optionally set an error message if no application number is provided
            session()->setFlashdata('error', 'No application selected for editing.');
            return redirect()->to('/view_application'); // Redirect to the application listing page
        }

        // Assuming you have the user data stored in the session
        $userData = $this->userData;

        // Get the database connection
        $db = \Config\Database::connect();

        // Fetch the specific application along with the program name
        $sql = "SELECT a.*, p.Name AS Program_Name 
            FROM Applications a
            LEFT JOIN Programs p ON a.Program_Num = p.Program_Num
            WHERE a.App_Num = ?";

        $query = $db->query($sql, [$appNum]);

        $application = $query->getRowArray(); // Use getRowArray() to fetch a single row

        // If the application does not exist handle it with an error message
        if (!$application) {
            // Optionally set an error message if no application is found
            session()->setFlashdata('error', 'Application not found.');
            return redirect()->to('/view_application'); // Redirect to the application listing page
        }

        // Assuming $programs is an array containing all available programs
        // This can also be fetched from the database if necessary
        $programsSql = "SELECT Program_Num, Name FROM Programs";
        $programsQuery = $db->query($programsSql);
        $programs = $programsQuery->getResultArray();

        // Load the edit application view with the application data and available programs
        return view('edit_application', ['appNum' => $appNum, 'userData' => $userData, 'application' => $application, 'programs' => $programs]);
    }

    /**
     * Updates the specified application with the provided data.
     *
     * @param int|null $appNum The application number to update. If not provided, an error message will be displayed and the user will be redirected to the application listing page.
     * @return \CodeIgniter\HTTP\RedirectResponse A redirect to the application listing page after the update is completed.
     */
    public function updateApplication($appNum = null)
    {

        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login'); // Redirect to login if not logged in
        }

        // Check if an application number has been provided
        if (!$appNum) {
            // Optionally set an error message if no application number is provided
            session()->setFlashdata('error', 'No application selected for editing.');
            return redirect()->to('/view_application'); // Redirect to the application listing page
        }

        // Validate the form data
        $input = $this->validate([
            'program' => 'required',
            'completed_certifications' => 'required',
            'uncompleted_certifications' => 'required',
            'purpose_statement' => 'required'
        ]);

        // If validation fails, redirect back to the profile update form with errors
        if (!$input) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        // Get the database connection
        $db = \Config\Database::connect();

        // Update the application in the database
        $sql = "UPDATE Applications SET Program_Num = ?, Com_Cert = ?, Uncom_Cert = ?, Purpose_Statement = ? WHERE App_Num = ?";
        $db->query($sql, [$this->request->getVar('program'), $this->request->getVar('completed_certifications'), $this->request->getVar('uncompleted_certifications'), $this->request->getVar('purpose_statement'), $appNum]);

        if($db->affectedRows() == 1){
            session()->setFlashdata('success', 'Application updated successfully!');
        } else {
            session()->setFlashdata('error', 'Application failed to update.');
        }

        return redirect()->to('/view_application');
    }

    /**
     * Deletes the specified application from the database.
     *
     * @param int|null $appNum The application number to be deleted. Null by default.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse Redirects to the application listing page after deleting the application.
     *
     * @throws \CodeIgniter\HTTP\RedirectException Throws a redirect exception if the user is not logged in or if no application number is provided.
     */
    public function deleteApplication($appNum = null)
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login'); // Redirect to login if not logged in
        }

        // Check if an application number has been provided
        if (!$appNum) {
            // Optionally set an error message if no application number is provided
            session()->setFlashdata('error', 'No application selected for deletion.');
            return redirect()->to('/view_application'); // Redirect to the application listing page
        }

        // Get the database connection
        $db = \Config\Database::connect();

        // Delete the application from the database
        $sql = "DELETE FROM Applications WHERE App_Num = ?";
        $db->query($sql, [$appNum]);

        if($db->affectedRows() == 1){
            session()->setFlashdata('success', 'Application deleted successfully!');
        } else {
            session()->setFlashdata('error', 'Application failed to delete.');
        }

        return redirect()->to('/view_application');
    }

}