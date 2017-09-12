<?php

class Database {

    private $db_host;
    private $db_name;
    private $db_username;
    private $db_password;
    private $connection;

    public function __construct($db_host, $db_name, $db_username, $db_password) {
        $this->db_host = $db_host;
        $this->db_name = $db_name;
        $this->db_username = $db_username;
        $this->db_password = $db_password;

        $this->connectToDatabase();
    }

    private function connectToDatabase() {
        $this->connection = mysqli_connect($this->db_host, $this->db_username, $this->db_password, $this->db_name);

        $this->checkConnection();
    }

    private function checkConnection() {
        if (!$this->connection) {
            die('Connection failed: ' . mysqli_connect_error());
        } else {
            echo 'Connected successfully';
        }
    }

    public function addUser($newUsername, $newPassword) {
        $sql = "INSERT INTO Users (username, password)
        VALUES ('" . $newUsername . "', '" . $newPassword . "')";
        
        if (mysqli_query($this->connection, $sql)) {
            echo 'New record created successfully';
        } else {
            echo 'Error: ' . $sql . '<br>' . mysqli_error($this->connection);
        }
    }
}