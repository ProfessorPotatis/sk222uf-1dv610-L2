<?php

class Session {
    private static $loggedIn = 'loggedIn';
    private static $cookiePassword = 'LoginView::CookiePassword';
    
    public function __construct() {
        $this->startSession();
    }

    public function startSession() {
        if (session_status() == PHP_SESSION_NONE) {
            ini_set('session.use_only_cookies', true);				
            ini_set('session.use_trans_sid', false);
            session_start();
        }
    }

    public function regenerateSessionId() {
        session_regenerate_id();
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