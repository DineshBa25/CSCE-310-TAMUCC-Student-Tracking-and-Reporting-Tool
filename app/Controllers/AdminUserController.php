<?php

namespace App\Controllers;

/**
 * Displays the "Edit User" view.
 *
 * This method checks if the user is logged in. If not, it redirects to the login page.
 * If the user is logged in and a UIN is provided, it retrieves the user data from the database
 * based on the provided UIN and loads the "edit_user" view. If the user does not exist in the database,
 * it redirects to the users listing page with an error message.
 * If the UIN is not provided, it sets an error flash message and redirects to the users listing page.
 * Additionally, if the user is a student, it fetches student-specific data and passes it to the view.
 *
 * @param string|null $uin The UIN of the user to edit. If not provided, an error flash message is shown and redirect to the user listing page.
 * @return \CodeIgniter\HTTP\RedirectResponse|string The response of the method can either be a redirect to login, the users listing page, or the "edit_user" view.
 *
 * @throws \CodeIgniter\Database\Exceptions\DatabaseException If there is an error while querying the database.
 */
class AdminUserController extends BaseController
{
    /**
     * Displays the "Add User" view.
     *
     * This method checks if the user is logged in. If not, it redirects to the login page.
     * If the user is logged in, it retrieves the user data from the session and loads the "add_user" view.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse|string The response of the method can either be a redirect to login or the "add_user" view.
     */
    public function viewAddUser()
    {

        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login'); // Redirect to login if not logged in
        }

        // Assuming you have the user data stored in the session
        $userData = $this->userData;

        // Load the add user view
        return view('add_user', ['userData' => $userData]);
    }

    /**
     * Adds a new user to the system.
     *
     * This method checks if the user is logged in. If not, it redirects to the login page.
     * If the user is logged in and a POST request is made, it validates the form data and
     * inserts the user into the Users table. If the user being added is a student, it also
     * inserts the student-specific information into the College_Student table.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse|null The response of the method can either be a redirect or null.
     */
    public function addUser()
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login'); // Redirect to login if not logged in
        }

        // Assuming this is a post request
        if ($this->request->getMethod() === 'post') {
            // Validate the form data
            $input = $this->validate([
                'username' => 'required',
                'user_type' => 'required',
                'uin' => 'required|integer',
                'password' => 'required',
                // Add other validations as per your form inputs
            ]);

            // if validation fails, redirect back to the form with errors
            if (!$input) {
                return redirect()->back()->withInput()->with('validation', $this->validator);
            }

            // Get the database connection
            $db = \Config\Database::connect();

            // Insert the user into the Users table
            $sql = "INSERT INTO Users (Username, User_Type, UIN, Passwords, M_Initial, Last_Name, IsActive, First_Name, Email, Discord_Name) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $db->query($sql, [
                $this->request->getVar('username'),
                $this->request->getVar('user_type'),
                $this->request->getVar('uin'),
                password_hash($this->request->getVar('password'), PASSWORD_DEFAULT), // Hash the password
                $this->request->getVar('middle_initial'),
                $this->request->getVar('last_name'),
                $this->request->getVar('is_active'),
                $this->request->getVar('first_name'),
                $this->request->getVar('email'),
                $this->request->getVar('discord_username'),
            ]);

            // Check if a student is being added
            if ($this->request->getVar('user_type') === 'Student') {
                // Insert the student-specific info into the College_Student table
                $sql = "INSERT INTO College_Student (UIN, Gender, Hispanic_Latino, Race, US_Citizen, First_Generation, DoB, GPA, Major, Minor_1, Minor_2, Expected_Graduation, School, Classification, Phone, Student_Type) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $db->query($sql, [
                    $this->request->getVar('uin'),
                    $this->request->getVar('gender'),
                    $this->request->getVar('hispanic_latino'),
                    $this->request->getVar('race'),
                    $this->request->getVar('us_citizen'),
                    $this->request->getVar('first_generation'),
                    $this->request->getVar('dob'),
                    $this->request->getVar('gpa'),
                    $this->request->getVar('major'),
                    $this->request->getVar('minor_1'),
                    $this->request->getVar('minor_2'),
                    $this->request->getVar('expected_graduation'),
                    $this->request->getVar('school'),
                    $this->request->getVar('classification'),
                    $this->request->getVar('phone'),
                    $this->request->getVar('student_type'),
                ]);
            }

            if ($db->affectedRows() > 0) {
                session()->setFlashdata('success', 'User added successfully!');
            } else {
                session()->setFlashdata('error', 'Failed to add user.');
            }

            return redirect()->to('/add_user'); // Redirect to the add_user page or to a confirmation page
        }
    }

    /**
     * Displays the "View Users" view.
     *
     * This method checks if the user is logged in. If not, it redirects to the login page.
     * If the user is logged in, it retrieves the user data from the session and the list of users from the database.
     * The retrieved users data is then passed to the "view_users" view for rendering.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse|string The response of the method can either be a redirect to login or the "view_users" view.
     *
     * @throws \CodeIgniter\Database\Exceptions\DatabaseException If there is an error while querying the database.
     */
    public function viewUsers()
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login'); // Redirect to login if not logged in
        }
        // Assuming you have the user data stored in the session
        $userData = $this->userData;

        // Get the database connection
        $db = \Config\Database::connect();

        // Fetch users from the database
        $sql = "SELECT * FROM Users"; // Adjust the table name as needed
        $query = $db->query($sql);

        $users = $query->getResultArray();

        // If no users exist handle it with an error message or set an empty array
        if (!$users) {
            // Optionally set an error message if no data found
            session()->setFlashdata('error', 'No users found.');
            return view('view_users', ['users' => []]);
        }

        // Load the users view with users data
        return view('view_users', ['userData' => $userData, 'users' => $users]);
    }

    /**
     * Displays the "Edit User" view.
     *
     * This method checks if the user is logged in. If not, it redirects to the login page.
     * If the user is logged in and a UIN is provided, it retrieves the user data from the database
     * based on the provided UIN and loads the "edit_user" view. If the user does not exist in the database,
     * it redirects to the users listing page with an error message.
     * If the UIN is not provided, it sets an error flash message and redirects to the users listing page.
     * Additionally, if the user is a student, it fetches student-specific data and passes it to the view.
     *
     * @param string|null $uin The UIN of the user to edit. If not provided, an error flash message is shown and redirect to the user listing page.
     * @return \CodeIgniter\HTTP\RedirectResponse|string The response of the method can either be a redirect to login, the users listing page, or the "edit_user" view.
     */
    public function viewEditUser($uin = null)
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login'); // Redirect to login if not logged in
        }

        // Check if a UIN has been provided
        if (!$uin) {
            // Optionally set an error message if no UIN is provided
            session()->setFlashdata('error', 'No user selected for editing.');
            return redirect()->to('/view_users'); // Redirect to the users listing page
        }

        // Get the database connection
        $db = \Config\Database::connect();

        // Fetch the specific user
        $sql = "SELECT * FROM Users WHERE UIN = ?";
        $query = $db->query($sql, [$uin]);
        $user = $query->getRowArray();

        // If the user does not exist handle it with an error message
        if (!$user) {
            session()->setFlashdata('error', 'User not found.');
            return redirect()->to('/view_users');
        }

        // Additionally, if the user is a student, fetch student-specific data
        $studentData = null;
        if ($user['User_Type'] === 'Student') {
            $sql = "SELECT * FROM College_Student WHERE UIN = ?";
            $query = $db->query($sql, [$uin]);
            $studentData = $query->getRowArray();
        }

        //log student data
        log_message('debug', 'Student Data: '.print_r($studentData, true));

        // Pass the user data and student-specific data (if any) to the view
        return view('edit_user', [
            'userData' => $user, // Contains user's general information
            'studentData' => $studentData // Contains student-specific information, if applicable
        ]);
    }

    /**
     * Updates a user's information.
     *
     * This method checks if the user is logged in. If not, it redirects to the login page.
     * If no user identification number (UIN) is provided, it sets an error flash message and redirects to the users listing page.
     * It validates the form data, and if validation fails, it redirects back to the form with errors.
     * It updates the user's information in the database, including their first name, last name, username, email, Discord username, user type, and active status.
     * If a new password is provided, it updates the user's password as well.
     * If the user is a student, it also updates their additional information in the College_Student table, such as gender, ethnicity, major, etc.
     * After the update, it sets a success or error flash message and redirects to the users listing page.
     *
     * @param string|null $uin The unique identification number of the user to update. If null, an error flash message will be set and a redirect will occur.
     * @return \CodeIgniter\HTTP\RedirectResponse The response of the method is always a redirect to the users listing page.
     */
    public function updateUser($uin = null)
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login'); // Redirect to login if not logged in
        }

        // Check if a UIN has been provided
        if (!$uin) {
            session()->setFlashdata('error', 'No user selected for updating.');
            return redirect()->to('/view_users'); // Redirect to the users listing page
        }

        // Validate the form data
        $input = $this->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            // Add other validations as needed
        ]);

        // If validation fails, redirect back to the form with errors
        if (!$input) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        // Get the database connection
        $db = \Config\Database::connect();

        // Prepare the base SQL query for updating the user
        $sql = "UPDATE Users SET First_Name = ?, Last_Name = ?, Username = ?, Email = ?, Discord_Name = ?, User_Type = ?, IsActive = ?";

        // Prepare an array with the base parameters
        $parameters = [
            $this->request->getVar('first_name'),
            $this->request->getVar('last_name'),
            $this->request->getVar('username'),
            $this->request->getVar('email'),
            $this->request->getVar('discord_username'),
            $this->request->getVar('user_type'),
            $this->request->getVar('is_active'),
        ];

        // Check if a new password is provided
        if (!empty($this->request->getVar('password'))) {
            $sql .= ", Passwords = ?";
            $parameters[] = password_hash($this->request->getVar('password'), PASSWORD_DEFAULT);
        }

        // Finalize the SQL query
        $sql .= " WHERE UIN = ?";
        $parameters[] = $uin;

        // Execute the query
        $db->query($sql, $parameters);

        // If the user is a student, update the College_Student table
        if ($this->request->getVar('user_type') === 'Student') {
            $sql = "UPDATE College_Student SET Gender = ?, Hispanic_Latino = ?, Race = ?, US_Citizen = ?, First_Generation = ?, DoB = ?, GPA = ?, Major = ?, Minor_1 = ?, Minor_2 = ?, Expected_Graduation = ?, School = ?, Classification = ?, Phone = ?, Student_Type = ? WHERE UIN = ?";
            $db->query($sql, [
                $this->request->getVar('gender'),
                $this->request->getVar('hispanic_latino'),
                $this->request->getVar('race'),
                $this->request->getVar('us_citizen'),
                $this->request->getVar('first_generation'),
                $this->request->getVar('dob'),
                $this->request->getVar('gpa'),
                $this->request->getVar('major'),
                $this->request->getVar('minor_1'),
                $this->request->getVar('minor_2'),
                $this->request->getVar('expected_graduation'),
                $this->request->getVar('school'),
                $this->request->getVar('classification'),
                $this->request->getVar('phone'),
                $this->request->getVar('student_type'),
                $uin
            ]);
        }

        // Check for successful update
        if ($db->affectedRows() > 0) {
            session()->setFlashdata('success', 'User updated successfully!');
        } else {
            session()->setFlashdata('error', 'User failed to update.');
        }

        return redirect()->to('/view_users');
    }


    /**
     * Deletes a user from the system.
     *
     * This method checks if the user is logged in. If not, it redirects to the login page.
     * If the user is logged in, it checks if a UIN (User Identification Number) has been provided.
     * If no UIN has been provided, it sets a flash message with an error and redirects to the users listing page.
     * If a UIN has been provided, it retrieves a database connection, starts a transaction, and deletes the user from the College_Student table and Users table.
     * After the deletion, it checks if the transaction was successful. If successful, it sets a success flash message and redirects to the users listing page.
     * If unsuccessful, it sets a flash message with an error and redirects to the users listing page.
     *
     * @param string|null $uin The User Identification Number (UIN) of the user to be deleted.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse|string The response of the method can either be a redirect to login or the users listing page.
     */
    public function deleteUser($uin = null)
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login'); // Redirect to login if not logged in
        }

        // Check if a UIN has been provided
        if (!$uin) {
            session()->setFlashdata('error', 'No user selected for deletion.');
            return redirect()->to('/view_users'); // Redirect to the users listing page
        }

        // Get the database connection
        $db = \Config\Database::connect();

        // Start a transaction
        $db->transStart();

        // First, delete the user from the College_Student table if they exist there
        $db->query("DELETE FROM College_Student WHERE UIN = ?", [$uin]);

        // Then, delete the user from the Users table
        $db->query("DELETE FROM Users WHERE UIN = ?", [$uin]);

        // Complete the transaction
        $db->transComplete();

        // Check if transaction was successful
        if ($db->transStatus() === FALSE) {
            session()->setFlashdata('error', 'User failed to delete.');
            return redirect()->to('/view_users');
        } else {
            session()->setFlashdata('success', 'User deleted successfully!');
            return redirect()->to('/view_users');
        }
    }

    /**
     * Deactivates a user in the system.
     *
     * This method checks if the user is logged in. If not, it redirects to the login page.
     * If the user is logged in, it checks if a UIN has been provided. If not, it sets an error flash message
     * and redirects to the users listing page. If a UIN has been provided, it deactivates the user in the database.
     * If the deactivation is successful, it sets a success flash message. If the deactivation fails, it sets an error
     * flash message. Finally, the method redirects to the users listing page.
     *
     * @param int|null $uin The UIN of the user to be deactivated.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse The response of the method is always a redirect to the users listing page.
     * The method sets flash messages to notify the user about the success or failure of the deactivation operation.
     */
    public function deactivateUser($uin = null)
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login'); // Redirect to login if not logged in
        }

        // Check if a UIN has been provided
        if (!$uin) {
            session()->setFlashdata('error', 'No user selected for deactivation.');
            return redirect()->to('/view_users'); // Redirect to the users listing page
        }

        // Get the database connection
        $db = \Config\Database::connect();

        // Deactivate the user in the database
        $sql = "UPDATE Users SET IsActive = 0 WHERE UIN = ?";
        $db->query($sql, [$uin]);

        if ($db->affectedRows() > 0) {
            session()->setFlashdata('success', 'User deactivated successfully!');
        } else {
            session()->setFlashdata('error', 'Failed to deactivate user.');
        }

        return redirect()->to('/view_users');
    }

    /**
     * Activates a user in the system.
     *
     * This method checks if the user is logged in. If not, it redirects to the login page.
     * If the user is logged in, it checks if a UIN (User Identification Number) has been provided.
     * If no UIN is provided, it sets a flash message indicating that no user has been selected for activation
     * and redirects to the users listing page.
     *
     * If a UIN is provided, it connects to the database and updates the IsActive column of the Users table to 1
     * for the specified UIN, indicating that the user has been activated.
     *
     * After updating the database, it sets a flash message indicating whether the user was activated successfully
     * or if there was a failure.
     *
     * Finally, it redirects to the users listing page.
     *
     * @param string|null $uin The User Identification Number of the user to be activated (optional).
     *
     * @return \CodeIgniter\HTTP\RedirectResponse The response of the method is always a redirect to the users listing page.
     */
    public function activateUser($uin = null)
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login'); // Redirect to login if not logged in
        }

        // Check if a UIN has been provided
        if (!$uin) {
            session()->setFlashdata('error', 'No user selected for activation.');
            return redirect()->to('/view_users'); // Redirect to the users listing page
        }

        // Get the database connection
        $db = \Config\Database::connect();

        // Activate the user in the database
        $sql = "UPDATE Users SET IsActive = 1 WHERE UIN = ?";
        $db->query($sql, [$uin]);

        if ($db->affectedRows() > 0) {
            session()->setFlashdata('success', 'User activated successfully!');
        } else {
            session()->setFlashdata('error', 'Failed to activate user.');
        }

        return redirect()->to('/view_users');
    }

}