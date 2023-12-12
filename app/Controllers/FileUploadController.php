<?php
// application/Controllers/FileUpload.php

namespace App\Controllers;
use App\Services\DropboxService;

use CodeIgniter\Controller;
use Kunnu\Dropbox\Dropbox;
use Kunnu\Dropbox\DropboxApp;
use Kunnu\Dropbox\DropboxFile;

/**
 * class FileUploadController
 *
 * This class handles file upload functionality, including validation, upload to Dropbox, and database insertion.
 * It extends the BaseController class.
 */
class FileUploadController extends BaseController
{
    /**
     * Function viewAddFile
     *
     * Checks if the user is logged in and loads the add file view with user data.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse|string Returns a redirect response to the login page if the user is not logged in,
     *         otherwise returns the add file view.
     */
    public function viewAddFile()
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login'); // Redirect to login if not logged in
        }

        // Assuming you have the user data stored in the session
        $userData = $this->userData;

        // Load the add program view
        return view('add_file', ['userData' => $userData]);
    }

    /**
     * Function addFile
     *
     * Checks if the user is logged in and validates the form data for uploading a file.
     * If the validation fails, log the errors and redirect back to the form with input and validation errors.
     * If the file is valid and has been uploaded, upload it to Dropbox with a unique name and insert the file information
     * into the database. Returns a redirect response to the add file page with success or error flash messages.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse Returns a redirect response to the login page if the user is not logged in,
     *         otherwise returns a redirect response to the add file page.
     */
    public function addFile()
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login'); // Redirect to login if not logged in
        }

        // Validate the form data
        $input = $this->validate([
            'filename' => 'required',
            'userfile' => 'uploaded[userfile]',
            'filetype' => 'required',
        ]);

        // If validation fails, redirect back to the form with errors
        if (!$input) {
            log_message('error', 'File upload validation failed.');
            log_message('error', $this->validator->listErrors());
            //log input
            log_message('error', $this->request->getVar('filename'));
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        // Get the file
        $file = $this->request->getFile('userfile');

        $dropbox = DropboxService::getDropboxClient();

        // Check if the file is valid and has been uploaded
        if ($file->isValid() && !$file->hasMoved()) {
            // Read file content as binary data
            $filePath = $file->getTempName();

            $dropboxFile = new DropboxFile($filePath);

            // Generate a unique hash (you can choose your preferred hashing method)
            $uniqueHash = md5(uniqid(rand(), true));

            // Combine the unique hash with the file extension (e.g., ".pdf")
            $fileName = $uniqueHash . ".pdf";

            // Upload the file with the unique name
            $fileUp = $dropbox->upload($dropboxFile, "/" . $fileName, ['autorename' => true]);

            $sharedLink = $dropbox->postToAPI("/sharing/create_shared_link_with_settings", [
                "path" => $fileUp->getPathDisplay(),
                "settings" => [
                    "requested_visibility" => "public"
                ]
            ]);

            $db = \Config\Database::connect();

            // Prepare the SQL query
            $sql = "INSERT INTO Document (UIN, Name, Link, File_Path, Doc_Type) VALUES (?, ?, ?, ?, ?)";

            $userID = session()->get('UIN');
            // Run the query
            $db->query($sql, [$userID, $this->request->getVar('filename') , $sharedLink->getDecodedBody()['url'], "/".$fileName, $this->request->getVar('filetype')]);

            // Check if the query was successful
            if ($db->affectedRows() == 1) {
                // Set a success flash message
                session()->setFlashdata('success', 'File uploaded successfully.');
                return redirect()->to('/add_file'); // Adjust the redirect as needed
            } else {
                // Handle error, file is not valid or not uploaded
                session()->setFlashdata('error', 'File is not valid or not uploaded.');
                return redirect()->back()->withInput();
            }
        } else {
            // Handle error, file is not valid or not uploaded
            session()->setFlashdata('error', 'File is not valid or not uploaded.');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Retrieves and displays the documents associated with the logged-in user's UIN.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse|string Returns a RedirectResponse object if the user is not logged in, otherwise returns a string containing the rendered view file with
     * the user's data and documents.
     */
    public function viewFile(){
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login'); // Redirect to login if not logged in
        }

        // Assuming you have the user data stored in the session
        $userData = $this->userData;

        // Get the database connection
        $db = \Config\Database::connect();

        // Get the documents for UIN from the database
        $sql = "SELECT Doc_Num, Name, Link FROM Document WHERE UIN = ?";

        $query = $db->query($sql, [session()->get('UIN')]);

        $documents = $query->getResultArray(); // Use getResultArray() to fetch multiple rows

        // Load the view file view with documents
        return view('view_file', ['userData' => $userData, 'documents' => $documents]);
    }

    /**
     * Retrieves and displays the selected document for editing, if the user is logged in and a valid application number is provided.
     *
     * @param string|null $appNum (optional) The application number of the document to be edited.
     * @return \CodeIgniter\HTTP\RedirectResponse|string Returns a RedirectResponse object if the user is not logged in or if no application number is provided, otherwise returns a string
     * containing the rendered view file with the user's data and the selected document for editing.
     */
    public function viewEditFile($appNum = null)
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login'); // Redirect to login if not logged in
        }

        // Check if an application number has been provided
        if (!$appNum) {
            // Optionally set an error message if no application number is provided
            session()->setFlashdata('error', 'No file selected for editing.');
            return redirect()->to('/view_file'); // Redirect to the application listing page
        }

        // Assuming you have the user data stored in the session
        $userData = $this->userData;

        // Get the database connection
        $db = \Config\Database::connect();


        // Get the documents for UIN from the database
        $sql = "SELECT Doc_Num, Name, Link, Doc_Type FROM Document WHERE Doc_Num = ?";

        $query = $db->query($sql, [$appNum]);

        $document = $query->getRowArray(); // Use getRowArray() to fetch a single row

        // If the application does not exist handle it with an error message
        if (!$document) {
            // Optionally set an error message if no application is found
            session()->setFlashdata('error', 'Document not found.');
            return redirect()->to('/view_document'); // Redirect to the application listing page
        }

        // Load the edit application view with programs
        return view('edit_file', ['userData' => $userData, 'document' => $document]);
    }

    /**
     * Updates a file in the application.
     *
     * @param mixed $appNum The application number (optional).
     * @return \CodeIgniter\HTTP\RedirectResponse Redirects to the specified page after updating the file.
     */
    public function updateFile($appNum = null)
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        // Check if an application number has been provided
        if (!$appNum) {
            // Optionally set an error message if no application number is provided
            session()->setFlashdata('error', 'No file selected for editing.');
            return redirect()->to('/view_file'); // Redirect to the application listing page
        }

        // Validate the form data
        $input = $this->validate([
            'filename' => 'required',
            'userfile' => 'uploaded[userfile]',
            'filetype' => 'required',
        ]);

        // If validation fails, redirect back to the form with errors
        if (!$input) {
            log_message('error', 'File upload validation failed.');
            log_message('error', $this->validator->listErrors());
            //log input
            log_message('error', $this->request->getVar('filename'));
            log_message('error', $this->request->getVar('filetype')
            );
            log_message('error', $this->request->getVar('userfile'));
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        // Get the file
        $file = $this->request->getFile('userfile');

        $dropbox = DropboxService::getDropboxClient();

        // Check if the file is valid and has been uploaded
        if ($file->isValid() && !$file->hasMoved()) {
            // Read file content as binary data
            $filePath = $file->getTempName();

            $dropboxFile = new DropboxFile($filePath);

            // Generate a unique hash (you can choose your preferred hashing method)
            $uniqueHash = md5(uniqid(rand(), true));

            $fileTypeOfFile = $file->getClientMimeType();
            // Combine the unique hash with the file extension (e.g., ".pdf")
            $fileName = $uniqueHash . ".pdf";

            // Upload the file with the unique name
            $fileUp = $dropbox->upload($dropboxFile, "/" . $fileName, ['autorename' => true]);

            $sharedLink = $dropbox->postToAPI("/sharing/create_shared_link_with_settings", [
                "path" => $fileUp->getPathDisplay(),
                "settings" => [
                    "requested_visibility" => "public"
                ]
            ]);

            $db = \Config\Database::connect();

            // Prepare the SQL query

            $sql = "UPDATE Document SET Name = ?, Link = ?, Doc_Type = ?, File_Path = ? WHERE Doc_Num = ?";

            // Run the query

            $db->query($sql, [$this->request->getVar('filename') , $sharedLink->getDecodedBody()['url'], $this->request->getVar('filetype'), "/".$fileName, $appNum]);

            // Check if the query was successful

            if ($db->affectedRows() == 1) {
                // Set a success flash message
                session()->setFlashdata('success', 'File updated successfully.');
                return redirect()->to('/view_file'); // Adjust the redirect as needed
            } else {
                // Handle error, file is not valid or not uploaded
                session()->setFlashdata('error', 'File is not valid or not uploaded.');
                return redirect()->back()->withInput();
            }
        } else {
            // Handle error, file is not valid or not uploaded
            session()->setFlashdata('error', 'File is not valid or not uploaded.');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Deletes a file from the application.
     *
     * @param mixed $appNum The application number (optional).
     * @return \CodeIgniter\HTTP\RedirectResponse Redirects to the specified page after deleting the file.
     */
    public function deleteFile($appNum = null)
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $dropbox = DropboxService::getDropboxClient();

        // Check if an application number has been provided
        if (!$appNum) {
            // Optionally set an error message if no application number is provided
            session()->setFlashdata('error', 'No file selected for deletion.');
            return redirect()->to('/view_file'); // Redirect to the application listing page
        }

        // Get the database connection
        $db = \Config\Database::connect();

        //get File_Path from document table
        $sql = "SELECT File_Path FROM Document WHERE Doc_Num = ?";
        $query = $db->query($sql, [$appNum]);
        $document = $query->getRowArray();
        $filePath = $document['File_Path'];
        //delete from dropbox
        $dropbox->delete($filePath);

        // Prepare the SQL query
        $sql = "DELETE FROM Document WHERE Doc_Num = ?";

        // Run the query
        $db->query($sql, [$appNum]);

        // Check if the query was successful
        if ($db->affectedRows() == 1) {


            // Set a success flash message
            session()->setFlashdata('success', 'File deleted successfully.');
            return redirect()->to('/view_file'); // Adjust the redirect as needed
        } else {
            // Handle error
            session()->setFlashdata('error', 'File not found.');
            return redirect()->to('/view_file'); // Adjust the redirect as needed
        }
    }
}
