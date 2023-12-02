<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class TestDB extends Controller
{
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
