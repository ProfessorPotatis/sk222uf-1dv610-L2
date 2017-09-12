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
        }
    }

    public function getMessage() {
        return $this->message;
    }

    private function checkIfProvidedUsername() {
        if ($_REQUEST[self::$providedUsername]) {
            $this->checkIfProvidedPassword();
        } else {
            $this->message = 'Username is missing';
        }
    }

    private function checkIfProvidedPassword() {
        if ($_REQUEST[self::$providedPassword]) {
            $this->checkIfCorrectUsername();
        } else {
            $this->message = 'Password is missing';
        }
    }

    //TODO: Change from hardcoded if-statement to looking for the username in database.
    private function checkIfCorrectUsername() {
        if ($_REQUEST[self::$providedUsername] == 'Admin') {
            $this->checkIfCorrectPassword();
        } else {
            $this->message = 'Wrong name or password';
        }
    }

    //TODO: Change from hardcoded if-statement to looking for the password in database.
    private function checkIfCorrectPassword() {
        if ($_REQUEST[self::$providedPassword] == 'Password') {
            echo 'Korrekt password';
        } else {
            $this->message = 'Wrong name or password';
        }
    }
}