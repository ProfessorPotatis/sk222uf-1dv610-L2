<?php

class LoginController {

    private static $providedUsername = 'LoginView::UserName';
    private static $providedPassword = 'LoginView::Password';

    private $message = '';
    private $db;
    
    public function __construct() {
        // ON PRODUCTION SERVER -> REMOVE SK222UF-1DV610-L2.
        require_once($_SERVER['DOCUMENT_ROOT'] . '/sk222uf-1dv610-L2/model/DBConfig.php');

        $this->db = new Database($db_host, $db_user, $db_password, $db_name);
    }

    public function handleLoginRequest() {
        if ($_POST) {
            $this->validateInputFields();
        }
    }

    public function getMessage() {
        return $this->message;
    }

    private function validateInputFields() {
        if ($_REQUEST[self::$providedUsername] == '') {
            $this->message = 'Username is missing';
        } else if ($_REQUEST[self::$providedPassword] == '') {
            $this->message = 'Password is missing';
        } else {
            $this->authenticateUser();
        }
    }

    private function authenticateUser() {
        $this->db->authenticate($_REQUEST[self::$providedUsername], $_REQUEST[self::$providedPassword]);
    }

    //TODO: Change from hardcoded if-statement to looking for the username in database.
    /*private function checkIfCorrectUsername() {
        if ($_REQUEST[self::$providedUsername] == 'Admin') {
            return $this->checkIfCorrectPassword();
        } else {
            $this->message = 'Wrong name or password';
        }
    }

    //TODO: Change from hardcoded if-statement to looking for the password in database.
    private function checkIfCorrectPassword() {
        if ($_REQUEST[self::$providedPassword] == 'Password') {
            $this->message = 'Welcome';
        } else {
            $this->message = 'Wrong name or password';
        }
    }*/
}