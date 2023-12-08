<?php
// File: app/Controllers/EventManagerController.php

namespace App\Controllers;

class EventController extends BaseController
{
    public function viewCreateEvent()
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
        $sql = "SELECT * FROM Event_Tracking";

        $query = $db->query($sql);

        $event_tracking = $query->getResultArray();

        // If no programs exist handle it with an error message or set an empty array
        if (!$event_tracking) {
            $event_tracking = [];
            // Optionally set an error message if no data found
            session()->setFlashdata('error', 'No Event data found.');
        }

        return view('create_event', ['userData' => $userData, 'event_tracking' => $event_tracking]);

    }

    public function submitEvent()
    {
        // check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login'); // Redirect to login if not logged in
        }

        // needs changing
        $input = $this->validate([
            'uin' => 'required|numeric',
            'program' => 'required',
            'start_date' => 'required',
            'start_time' => 'required',
            'location' => 'required',
            'end_date' => 'required',
            'end_time' => 'required',
            'event_type' => 'required'
            
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
        $sql = "INSERT INTO Event (UIN, Program_Num, Start_Date, Start_Time, Location, End_date, End_Time, Event_Type) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $db->query($sql, [$this->request->getVar('uin'), $this->request->getVar('program'), $this->request->getVar('start_date'), $this->request->getVar('start_time'), $this->request->getVar('end_date'), $this->request->getVar('end_time'), $this->request->getVar('event_type')]);

        if($db->affectedRows() == 1){
            session()->setFlashdata('success', 'Application submitted successfully!');
        } else {
            session()->setFlashdata('error', 'Application failed to submit.');
        }

        return redirect()->to('/create_event');
    }

    public function viewEvent()
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
        $sql = "SELECT e.*, p.Name
                FROM Event e
                LEFT JOIN Programs p ON e.Program_Num = p.Name;";

        $query = $db->query($sql, [$userId]);

        $events = $query->getResultArray();

        // If no applications exist handle it with an error message or set an empty array
        if (!$events) {
            // Optionally set an error message if no data found
            session()->setFlashdata('error', 'No Events found.');
            return view('view_event', ['userData' => $userData, 'events' => []]);
        }

        // Load student application view with programs
        return view('view_event', ['userData' => $userData, 'events' => $events]);
    }

    public function viewEditEvent($eventID= null)
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login'); // Redirect to login if not logged in
        }

        // Check if an application number has been provided
        if (!$eventID) {
            // Optionally set an error message if no application number is provided
            session()->setFlashdata('error', 'No application selected for editing.');
            return redirect()->to('/view_event'); // Redirect to the application listing page
        }

        // Assuming you have the user data stored in the session
        $userData = $this->userData;

        // Get the database connection
        $db = \Config\Database::connect();

        // Fetch the specific application along with the program name
        $sql = "SELECT e.*, p.Name AS Program_Name 
            FROM Event e
            LEFT JOIN Programs p ON e.Program_Num = p.Program_Num
            WHERE e.Event_ID = ?";

        $query = $db->query($sql, [$eventID]);

        $event = $query->getRowArray(); // Use getRowArray() to fetch a single row

        // If the application does not exist handle it with an error message
        if (!$event) {
            // Optionally set an error message if no application is found
            session()->setFlashdata('error', 'Event not found.');
            return redirect()->to('/view_event'); // Redirect to the application listing page
        }

        // Assuming $programs is an array containing all available programs
        // This can also be fetched from the database if necessary
        $programsSql = "SELECT Program_Num, Name FROM Programs";
        $programsQuery = $db->query($programsSql);
        $programs = $programsQuery->getResultArray();

        // Load the edit application view with the application data and available programs
        return view('edit_event', ['eventid' => $eventID, 'userData' => $userData, 'event' => $event, 'programs' => $programs]);
    }

    public function updateEvent($eventID = null)
    {

        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login'); // Redirect to login if not logged in
        }

        // Check if an application number has been provided
        if (!$eventID) {
            // Optionally set an error message if no application number is provided
            session()->setFlashdata('error', 'No Event selected for editing.');
            return redirect()->to('/view_event'); // Redirect to the application listing page
        }

        // Validate the form data
        $input = $this->validate([
            'uin' => 'required|numeric',
            'program' => 'required',
            'start_date' => 'required',
            'start_time' => 'required',
            'location' => 'required',
            'end_date' => 'required',
            'end_time' => 'required',
            'event_type' => 'required'
        ]);

        // If validation fails, redirect back to the profile update form with errors
        if (!$input) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        // Get the database connection
        $db = \Config\Database::connect();

        // Update the application in the database
        $sql = "UPDATE Event SET UIN = ?, Program = ?, Start_Date = ?, Start_Time = ?, Location = ?, End_Date = ?, End_Time = ?, Event_Type = ? WHERE EventID = ?";
        $db->query($sql, [$this->request->getVar('uin'), $this->request->getVar('program'), $this->request->getVar('start_date'), $this->request->getVar('start_time'),$this->request->getVar('location'), $this->request->getVar('end_date'), $this->request->getVar('end_time'), $this->request->getVar('event_type'), $eventID]);

        if($db->affectedRows() == 1){
            session()->setFlashdata('success', 'Event updated successfully!');
        } else {
            session()->setFlashdata('error', 'Event failed to update.');
        }

        return redirect()->to('/view_event');
    }

    public function deleteEvent($eventID = null)
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login'); // Redirect to login if not logged in
        }

        // Check if an application number has been provided
        if (!$eventID) {
            // Optionally set an error message if no application number is provided
            session()->setFlashdata('error', 'No event selected for deletion.');
            return redirect()->to('/view_event'); // Redirect to the application listing page
        }

        // Get the database connection
        $db = \Config\Database::connect();

        // Delete the application from the database
        $sql = "DELETE FROM Event WHERE Event_ID = ?";
        $db->query($sql, [$eventID]);

        if($db->affectedRows() == 1){
            session()->setFlashdata('success', 'Event deleted successfully!');
        } else {
            session()->setFlashdata('error', 'Event failed to delete.');
        }

        return redirect()->to('/view_event');
    }
    public function viewEventTracking()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login'); // Redirect to login if not logged in
        }

        // Assuming you have the user data stored in the session
        $userData = $this->userData;

        // Get the user's ID from the session or other source
        $userId = session()->get('UIN'); // Ensure 'userId' is the correct session key that contains the UIN.

        // Get the database connection
        $db = \Config\Database::connect();

        $sql = "SELECT * FROM Event_Tracking";

        $query = $db->query($sql, [$userId]);

        $event_trackings = $query->getResultArray();

        // If no applications exist handle it with an error message or set an empty array
        if (!$event_trackings) {
            // Optionally set an error message if no data found
            session()->setFlashdata('error', 'No Events found.');
            return view('view_event', ['userData' => $userData, 'events' => []]);
        }

        // Load student application view with programs
        return view('view_event_tracking', ['userData' => $userData, 'event_trackings' => $event_trackings]);
    }

    public function viewEditEventTracking($et_num= null)
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login'); // Redirect to login if not logged in
        }

        // Check if an application number has been provided
        if (!$et_num) {
            // Optionally set an error message if no application number is provided
            session()->setFlashdata('error', 'No application selected for editing.');
            return redirect()->to('/view_event_tracking'); // Redirect to the application listing page
        }

        // Assuming you have the user data stored in the session
        $userData = $this->userData;

        // Get the database connection
        $db = \Config\Database::connect();

        // Fetch the specific application along with the program name
        $sql = "SELECT * FROM Event_Tracking";

        $query = $db->query($sql, [$et_num]);

        $event_tracking = $query->getRowArray(); // Use getRowArray() to fetch a single row

        // If the application does not exist handle it with an error message
        if (!$event_tracking) {
            // Optionally set an error message if no application is found
            session()->setFlashdata('error', 'Event not found.');
            return redirect()->to('/view_event_tracking'); // Redirect to the application listing page
        }

        
       

        // Load the edit application view with the application data and available programs
        return view('edit_event_tracking', ['et_num' => $et_num, 'userData' => $userData, 'event_tracking' => $event_tracking]);
    }

    public function updateEventTracking($event_tracking = null)
    {

        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login'); // Redirect to login if not logged in
        }

        // Check if an application number has been provided
        if (!$et_num) {
            // Optionally set an error message if no application number is provided
            session()->setFlashdata('error', 'No Event selected for editing.');
            return redirect()->to('/view_event_tracking'); // Redirect to the application listing page
        }

        // Validate the form data
        $input = $this->validate([
            'event_id' => 'required|numeric',
            'uin' => 'required|numeric',
        ]);

        // If validation fails, redirect back to the profile update form with errors
        if (!$input) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        // Get the database connection
        $db = \Config\Database::connect();

        // Update the application in the database
        $sql = "UPDATE Event_Tracking SET Event_ID = ?, UIN = ? WHERE ET_Num = ?";
        $db->query($sql, [$this->request->getVar('event_id'), $this->request->getVar('uin'), $et_num]);

        if($db->affectedRows() == 1){
            session()->setFlashdata('success', 'Event updated successfully!');
        } else {
            session()->setFlashdata('error', 'Event failed to update.');
        }

        return redirect()->to('/view_event_tracking');
    }

}