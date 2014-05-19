<?php
/**
 * database.php
 * Created at 5/19/14
 */

class Database {

    public $db;

    private $credentials;

    public function __construct($credentials = array()) {

        // Store our credentials

        $this->credentials = array(
            'host' => $credentials['host'], 'user' => $credentials['user'], 'password' => $credentials['password'], 'database' => $credentials['database']
        );

        try {

            // Create the PDO connection object

            $this->db = new PDO('mysql:host=s'.$credentials['host'].';dbname='.$credentials['database'], $credentials['user'], $credentials['password']);

        } catch (PDOException $error) {

            die('<h4>Error occurred while creating the PDO connection</h4><br>'.$error);
        }
    }
}