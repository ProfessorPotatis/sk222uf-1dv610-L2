<?php

class Session {
    private static $loggedIn = 'loggedIn';
    
    public function __construct() {
        $this->startSession();
    }

    public function startSession() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function setSessionVariable($name, $value) {
        $_SESSION[$name] = $value;
    }

    public function getSessionVariable($sessionVariable) {
        return $_SESSION[$sessionVariable];
    }

    public function unsetSessionVariable($sessionVariable) {
        unset($_SESSION[$sessionVariable]);
    }

    public function isLoggedIn() {
        if (isset($_SESSION[self::$loggedIn]) && $this->getSessionVariable(self::$loggedIn)) {
            return true;
        } else {
            return false;
        }
    }
}