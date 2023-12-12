<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class TestDB extends Controller
{
    /**
     * Attempts to connect to the database and executes a query to retrieve all rows from the Users table.
     * Outputs the retrieved rows and displays the database configuration, tables, and connection start time.
     * Displays a success message if the connection is successful, otherwise displays an error message.
     *
     * @return void
     */
    public function getIndex()
    {
        echo "Attempting to connect to the database...<br>";

        $db = \Config\Database::connect();

        //make query
        $query = $db->query('SELECT * FROM Users');
        $results = $query->getResult();

        foreach ($results as $row)
        {
            print_r($row);
        }

        // Debugging: Output the database configuration
        var_dump($db->getDatabase());
        echo '<br>';
        var_dump($db->listTables());
        echo '<br>';
        var_dump($db->getConnectStart());
        echo '<br>';

        if ($db->connID) {
            echo 'Connection successful!';
        } else {
            // If the connection fails, display error information
            echo 'Connection failed!<br>';
        }
    }
}
