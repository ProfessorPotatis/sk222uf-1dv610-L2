<?php

class LoginController {

    private static $providedUsername = 'LoginView::UserName';
    private static $providedPassword = 'LoginView::Password';

    private $message = '';
    private $db;
    private $isAuthenticated;
    
    public function __construct() {
        // ON PRODUCTION SERVER -> REMOVE SK222UF-1DV610-L2.
        require_once($_SERVER['DOCUMENT_ROOT'] . '/sk222uf-1dv610-L2/model/DBConfig.php');

        $this->db = new Database($db_host, $db_user, $db_password, $db_name);
    }

    public function handleLoginRequest() {
        if ($_POST) {
            $this->validateInputFields();
            return $this->isAuthenticated;
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
        $this->isAuthenticated = $this->db->authenticate($_REQUEST[self::$providedUsername], $_REQUEST[self::$providedPassword]);
        
        if ($this->isAuthenticated) {
            $this->message = 'Welcome';
        } else {
            $this->message = 'Wrong name or password';
        }
    }
}