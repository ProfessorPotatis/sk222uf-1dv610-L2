<?php

class LoginController {

    private static $providedUsername = 'LoginView::UserName';
    private static $providedPassword = 'LoginView::Password';

    private $message = '';
    
    public function __construct() {

    }

    public function handleLoginRequest() {
        if ($_POST) {
            $this->checkIfProvidedUsername();
            //var_dump($_POST);
        }
    }

    public function getMessage() {
        return $this->message;
    }

    private function checkIfProvidedUsername() {
        if ($_REQUEST[self::$providedUsername]) {
            $this->checkIfProvidedPassword();
            //echo 'hej';
        } else {
            $this->message = 'Username is missing';
        }
    }

    private function checkIfProvidedPassword() {
        if ($_REQUEST[self::$providedPassword]) {
            echo 'password hej';
        } else {
            $this->message = 'Password is missing';
        }
    }
}