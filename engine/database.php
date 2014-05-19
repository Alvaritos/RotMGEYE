<?php
/**
 * database.php
 * Created at 5/19/14
 */

class Database {

    public $_db;

    private $_credentials;

    public function __construct($credentials = array()) {

        // Store our credentials

        $this->_credentials = array(
            'host' => $credentials['host'], 'user' => $credentials['user'], 'password' => $credentials['password'], 'database' => $credentials['database']
        );

        try {

            // Create the PDO connection object

            $this->_db = new PDO('mysql:host='.$credentials['host'].';dbname='.$credentials['database'], $credentials['user'], $credentials['password']);

        } catch (PDOException $error) {

            die('<h4>Error occurred while creating the PDO connection</h4><br>'.$error);
        }
    }

    public function multipleQuery($query, $params = array()) {

        $query = $this->_db->prepare($query);

        if ($query->execute($params)) {

            return $query->fetchAll();

        } else {

            return false;
        }
    }

    public function simpleQuery($query) {

        $query = $this->_db->prepare($query);

        if ($query->execute()) {

            return $query->fetchAll();

        } else {

            return false;
        }
    }
}