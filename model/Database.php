<?php

class Database {

    private $db_host;
    private $db_username;
    private $db_password;
    private $db_name;
    private $connection;

    public function __construct($db_host, $db_username, $db_password, $db_name) {
        $this->db_host = $db_host;
        $this->db_username = $db_username;
        $this->db_password = $db_password;
        $this->db_name = $db_name;

        //$this->connectToDatabase();
    }

    private function connectToDatabase() {
        $this->connection = mysqli_connect($this->db_host, $this->db_username, $this->db_password, $this->db_name);

        $this->checkConnection();
    }

    private function checkConnection() {
        if (!$this->connection) {
            die('Connection failed: ' . mysqli_connect_error());
        } else {
            //echo 'Connected successfully';
        }
    }

    private function disconnect() {
        mysqli_close($this->connection);
    }

    public function addUser($newUsername, $newPassword) {
        $this->connectToDatabase();

        $encryptedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $sql = "INSERT INTO Users (username, password)
        VALUES ('" . $newUsername . "', '" . $encryptedPassword . "')";
        
        if (mysqli_query($this->connection, $sql)) {
            echo 'New record created successfully';
        } else {
            echo 'Error: ' . $sql . '<br>' . mysqli_error($this->connection);
        }

        $this->disconnect();
    }

    public function authenticate($username, $password) {
        $this->connectToDatabase();

        $query = "SELECT * FROM `Users` WHERE username='" . $username . "'";

        if ($stmt = mysqli_prepare($this->connection, $query)) {
            mysqli_stmt_execute($stmt);
            
            /* bind result variables */
            mysqli_stmt_bind_result($stmt, $dbUsername, $dbPassword);
            
            /* fetch value */
            while (mysqli_stmt_fetch($stmt)) {
                $this->verifyPassword($password, $dbPassword);
                printf("%s %s\n", $dbUsername, $dbPassword);
            }
            
            /* close statement */
            mysqli_stmt_close($stmt);
        }

        $this->disconnect();
    }

    private function verifyPassword($password, $dbPassword) {
        if (password_verify($password, $dbPassword)) {
            echo 'Password is valid!';
        } else {
            echo 'Invalid password.';
        }
    }
}