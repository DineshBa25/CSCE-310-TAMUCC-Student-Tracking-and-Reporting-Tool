<?php
// File: app/Controllers/ProfileController.php

namespace App\Controllers;

class ProfileController extends BaseController
{
    public function viewUpdateProfile()
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
        $sql = "SELECT * FROM College_Student WHERE UIN = 123001234";
        $query = $db->query($sql, [$userId]);
        $studentData = $query->getRowArray();

        // If student data is not found, you can handle it with an error message or set an empty array
        if (!$studentData) {
            $studentData = [];
            // Optionally set an error message if no data found
            // session()->setFlashdata('error', 'No student data found.');
        }

        // Load the dashboard view with both user and student data
        return view('view_update_profile', ['userData' => $userData, 'studentData' => $studentData]);
    }


    /**
     * @throws \ReflectionException
     */
    public function updateProfileProcess()
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login'); // Redirect to login if not logged in
        }

        // Validate the form data
        $input = $this->validate([
            'first_name' => 'required|alpha_space',
            'm_initial' => 'permit_empty|alpha',
            'last_name' => 'required|alpha_space',
            'email' => 'required|valid_email',
            // add validation rules for other fields as needed
        ]);

        // If validation fails, redirect back to the profile update form with errors
        if (!$input) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        // Get the user's ID from the session or other source
        $userId = session()->get('UIN');

        // Check that we have an ID to prevent updating all rows
        if ($userId === null) {
            // Handle the error appropriately
            session()->setFlashdata('error', 'An error occurred. No user ID provided.');
            return redirect()->back();
        }

        // Assuming you have a UserModel to handle database operations
        $db = \Config\Database::connect();

        // Manually build the SQL query
        $sql = "UPDATE Users SET First_Name = ?, M_Initial = ?, Last_Name = ?, Email = ? WHERE UIN = ?";

        // Get the values to update
        $params = [
            $this->request->getPost('first_name'),
            $this->request->getPost('m_initial'),
            $this->request->getPost('last_name'),
            $this->request->getPost('email'),
            $userId // The WHERE clause value
        ];

        try {
            // Execute the query
            $db->query($sql, $params);

            if ($db->affectedRows() > 0) {
                // Set a success message
                session()->setFlashdata('success', 'Profile updated successfully.');
            } else {
                // Set a warning message if no rows were updated
                session()->setFlashdata('warning', 'No changes were made to your profile.');
            }
        } catch (\Exception $e) {
            // Set an error message if an exception occurred
            session()->setFlashdata('error', 'Failed to update profile. Error: ' . $e->getMessage());
        }

        // Redirect back to the profile update form
        return redirect()->to('/profile/update');
    }

    public function deactivateAccount()
    {
        // Check if user is logged in and get the user's ID
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login'); // Redirect to login if not logged in
        }

        $userId = session()->get('UIN'); // Replace 'userId' with the actual session key used

        // Get the database connection
        $db = \Config\Database::connect();

        // SQL query to update the IsActive field to false
        $sql = "UPDATE Users SET IsActive = false WHERE UIN = ?";

        try {
            // Execute the query
            $db->query($sql, [$userId]);

            // Check if any rows were affected
            if ($db->affectedRows() > 0) {
                // Set a success message
                session()->setFlashdata('success', 'Account has been successfully deactivated.');
            } else {
                // Set a warning message if no rows were updated
                session()->setFlashdata('warning', 'No changes were made to your account.');
            }
        } catch (\Exception $e) {
            // Set an error message if an exception occurred
            session()->setFlashdata('error', 'Failed to deactivate account. Error: ' . $e->getMessage());
        }

        // Redirect to a confirmation page or back to the dashboard
        return redirect()->to('/login');
    }

    public function permenantlyDeleteAccount()
    {
        // Check if user is logged in and get the user's ID
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login'); // Redirect to login if not logged in
        }

        $userId = session()->get('UIN'); // Replace 'userId' with the actual session key used

        // Get the database connection
        $db = \Config\Database::connect();

        // SQL query to delete the user's account
        $sql = "DELETE FROM Users WHERE UIN = ?";

        $sql2 = "DELETE FROM College_Student WHERE UIN = ?";

        try {
            // Execute both queries
            $db->query($sql2, [$userId]);

            $db->query($sql, [$userId]);

            // Check if any rows were affected
            if ($db->affectedRows() > 0) {
                // Set a success message
                session()->setFlashdata('success', 'Account has been successfully deleted.');
            } else {
                // Set a warning message if no rows were updated
                session()->setFlashdata('warning', 'No changes were made to your account.');
            }
        } catch (\Exception $e) {
            // Set an error message if an exception occurred
            session()->setFlashdata('error', 'Failed to delete account. Error: ' . $e->getMessage());
        }

        // Redirect to a confirmation page or back to the dashboard
        return redirect()->to('/login');
    }

    public function changePassword()
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login'); // Redirect to login if not logged in
        }

        // Validate the form data
        $input = $this->validate([
            'current_password' => 'required',
            'new_password' => 'required|min_length[8]',
            'confirm_new_password' => 'required|matches[new_password]'
        ]);

        if (!$input) {
            // If validation fails, redirect back to the form with errors
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Get the user's ID and current password
        $userId = session()->get('UIN');
        $currentPassword = $this->request->getPost('current_password');
        $newPassword = $this->request->getPost('new_password');

        $userModel = new \App\Models\UserModel(); // Make sure to use your actual UserModel path
        $user = $userModel->find($userId);

        // Verify the current password
        if (!password_verify($current_password, $user['Passwords'])) {
            session()->setFlashdata('error', 'Current password is incorrect.');
            return redirect()->back();
        }

        // Update the user's password
        $updated = $userModel->update($userId, [
            'Passwords' => password_hash($newPassword, PASSWORD_DEFAULT)
        ]);

        if ($updated) {
            session()->setFlashdata('success', 'Password changed successfully.');
        } else {
            session()->setFlashdata('error', 'Failed to change password.');
        }

        // Redirect back to the profile update form
        return redirect()->to('/profile/update');
    }
}