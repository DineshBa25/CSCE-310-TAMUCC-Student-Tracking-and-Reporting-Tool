<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel; // Import the UserModel

/**
 * Class Login
 *
 * This class represents the Login functionality of the application.
 */
class Login extends Controller
{
    // Declare a private property to hold the UserModel instance
    private $userModel;

    /**
     * Constructs a new instance of the class.
     *
     * Initializes the UserModel instance in the constructor.
     *
     * @return void
     */
    public function __construct()
    {
        // Initialize the UserModel instance in the constructor
        $this->userModel = new UserModel();
    }

    /**
     * Displays the login view.
     *
     * This method is responsible for returning the login view.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('login');
    }

    /**
     * Authenticates user credentials.
     *
     * Retrieves the username and password from the request.
     * Retrieves user data from the UserModel based on the provided username.
     * Uses password_verify() to authenticate the provided password against the stored password.
     * If authentication succeeds, sets the user session data and redirects to the dashboard.
     * If authentication fails, sets a flash message and redirects to the login page.
     * If the provided username does not exist, sets a flash message and redirects to the login page.
     *
     * @return CodeIgniter\HTTP\RedirectResponse The redirect response to the dashboard or login page.
     */
    public function authenticate()
    {
        $session = session();
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        // Retrieve user data from the UserModel
        $data = $this->userModel->where('username', $username)->first();

        if ($data) {
            $pass = $data['Passwords'];
            $authenticatePassword = password_verify($password, $pass);
            //log password
            if ($authenticatePassword) {
                $ses_data = [
                    'username' => $data['Username'],
                    'isLoggedIn' => TRUE
                ];
                $session->set($ses_data);
                session()->set('UIN', $data['UIN']);
                return redirect()->to('/dashboard');
            } else {
                $session->setFlashdata('msg', 'Wrong Password');
                return redirect()->to('/login');
            }
        } else {
            $session->setFlashdata('msg', 'Username does not exist');
            return redirect()->to('/login');
        }
    }

    /**
     * Register a new user.
     *
     * Validates the registration form inputs and inserts the user data into the database.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function register()
    {
        // Validation rules for registration form
        $validationRules = [
            'uin' => 'required|is_unique[Users.UIN]|exact_length[9]|numeric',
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required|is_unique[Users.Username]',
            'password' => 'required|min_length[6]',
            'user_type' => 'required',
            'email' => 'required|valid_email|is_unique[Users.Email]',
            'discord_name' => 'required',
            'gender' => 'required|in_list[Male,Female,Other]',
            'race' => 'required',
            'us_citizen' => 'required',
            'first_generation' => 'required',
            'dob' => 'required',
            'gpa' => 'required|decimal',
            'major' => 'required',
            'minor_1' => 'permit_empty',
            'minor_2' => 'permit_empty',
            'expected_graduation' => 'required|integer',
            'school' => 'required',
            'classification' => 'required',
            'phone' => 'required',
            'student_type' => 'required|in_list[Full-Time,Part-Time]'
        ];

        if (!$this->validate($validationRules)) {
            // Validation failed, return with validation errors
            return redirect()->to('/register')->withInput()->with('validation', $this->validator);
        }

        // Get user input
        $data = [
            'UIN' => $this->request->getPost('uin'),
            'First_Name' => $this->request->getPost('first_name'),
            'Last_Name' => $this->request->getPost('last_name'),
            'Username' => $this->request->getPost('username'),
            'Passwords' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT), // Hash the password
            'User_Type' => $this->request->getPost('user_type'),
            'Email' => $this->request->getPost('email'),
            'Discord_Name' => $this->request->getPost('discord_name'),
            'IsActive' => 1, // Set IsActive to 1 for active users
            'Gender' => $this->request->getPost('gender'),
            'Race' => $this->request->getPost('race'),
            'US_Citizen' => $this->request->getPost('us_citizen') ? 1 : 0,
            'First_Generation' => $this->request->getPost('first_generation') ? 1 : 0,
            'DoB' => $this->request->getPost('dob'),
            'GPA' => $this->request->getPost('gpa'),
            'Major' => $this->request->getPost('major'),
            'Minor_1' => $this->request->getPost('minor_1'),
            'Minor_2' => $this->request->getPost('minor_2'),
            'Expected_Graduation' => $this->request->getPost('expected_graduation'),
            'School' => $this->request->getPost('school'),
            'Classification' => $this->request->getPost('classification'),
            'Phone' => $this->request->getPost('phone'),
            'Student_Type' => $this->request->getPost('student_type'),
        ];

        // Manually build the SQL query for insertion
        $sql = "INSERT INTO Users (UIN, First_Name, Last_Name, Username, Passwords, User_Type, Email, Discord_Name, IsActive) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // Get the values to insert
        $params = [
            $data['UIN'],
            $data['First_Name'],
            $data['Last_Name'],
            $data['Username'],
            $data['Passwords'],
            $data['User_Type'],
            $data['Email'],
            $data['Discord_Name'],
            $data['IsActive']
        ];

        // Execute the SQL query
        $db = \Config\Database::connect();
        $db->query($sql, $params);


        // Insert student-specific data into College_Student table if the user is a student
        if ($data['User_Type'] === 'Student') {
            $sql = "INSERT INTO College_Student (UIN, Gender, Race, US_Citizen, First_Generation, DoB, GPA, Major, Minor_1, Minor_2, Expected_Graduation, School, Classification, Phone, Student_Type) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $params = [
                $data['UIN'],
                $data['Gender'],
                $data['Race'],
                $data['US_Citizen'],
                $data['First_Generation'],
                $data['DoB'],
                $data['GPA'],
                $data['Major'],
                $data['Minor_1'],
                $data['Minor_2'],
                $data['Expected_Graduation'],
                $data['School'],
                $data['Classification'],
                $data['Phone'],
                $data['Student_Type'],
            ];
            $db->query($sql, $params);
        }


        // Set a flash message for successful registration
        session()->setFlashdata('success', 'Registration successful. You can now login.');

        // Redirect to the login page
        return redirect()->to('/login');
    }

    /**
     * Displays the registration page.
     *
     * Loads the 'register.php' view, which contains the HTML form for user registration.
     *
     * @return \Illuminate\Contracts\View\View The registration page view.
     */
    public function registerPage()
    {
        return view('register'); // Load the 'register.php' view
    }

    /**
     * Logs out the user.
     *
     * Destroys the session and redirects the user to the login page.
     *
     * @return void
     */
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

    /**
     * Renders the view for resetting the password.
     *
     * This method returns the HTML view template for resetting the password.
     *
     * @return string The HTML view template for resetting the password.
     */
    public function viewResetPassword()
    {
        return view('reset_password');
    }

    /**
     * Resets the password for a user.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse The redirect response.
     * @throws \ReflectionException If an error occurs while reflecting the code.
     */
    public function resetPassword()
    {
        $session = session();
        $username = $this->request->getVar('username');
        $currentPassword = $this->request->getVar('current_password');
        $newPassword = $this->request->getVar('new_password');
        $confirmPassword = $this->request->getVar('confirm_password');

        // Retrieve user data from the UserModel
        $data = $this->userModel->where('username', $username)->first();

        if (!$data) {
            $session->setFlashdata('error', 'Username does not exist');
            return redirect()->to('/reset_password');
        }

        // Verify the current password
        if (!password_verify($currentPassword, $data['Passwords'])) {
            $session->setFlashdata('error', 'Incorrect current password.');
            return redirect()->to('/reset_password')->withInput();
        }

        // Check if new password matches confirm password
        if ($newPassword !== $confirmPassword) {
            $session->setFlashdata('error', 'Password and Confirm Password do not match.');
            return redirect()->to('/reset_password')->withInput();
        }

        // Update the user's password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $this->userModel->update($data['UIN'], ['Passwords' => $hashedPassword]);

        $session->setFlashdata('success', 'Password reset successfully.');
        return redirect()->to('/login');
    }
}
