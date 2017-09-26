<?php

class FormValidator {

    private static $registerName = 'RegisterView::UserName';
	private static $registerPassword = 'RegisterView::Password';
	private static $repeatPassword = 'RegisterView::PasswordRepeat';
	private static $registerMessage = 'RegisterView::Message';
    private static $register = 'RegisterView::Register';
    
    private $session;

    public function __construct() {
        $this->session = new Session();
    }

    public function validateInputFields() {
        if (strlen($_REQUEST[self::$registerName]) == 0 && strlen($_REQUEST[self::$registerPassword]) == 0) {
            $this->session->setSessionVariable('message', 'Username has too few characters, at least 3 characters. Password has too few characters, at least 6 characters.');
        } else if (strlen($_REQUEST[self::$registerName]) < 3) {
            $this->session->setSessionVariable('username', $_REQUEST[self::$registerName]);
            $this->session->setSessionVariable('message', 'Username has too few characters, at least 3 characters.');
        } else if (strlen($_REQUEST[self::$registerPassword]) < 6) {
            $this->session->setSessionVariable('username', $_REQUEST[self::$registerName]);
            $this->session->setSessionVariable('message', 'Password has too few characters, at least 6 characters.');
        } else if ($_REQUEST[self::$repeatPassword] !== $_REQUEST[self::$registerPassword]) {
            $this->session->setSessionVariable('username', $_REQUEST[self::$registerName]);
            $this->session->setSessionVariable('message', 'Passwords do not match.');
        } else if (strip_tags($_REQUEST[self::$registerName]) !== $_REQUEST[self::$registerName]) {
            $this->session->setSessionVariable('username', strip_tags($_REQUEST[self::$registerName]));
            $this->session->setSessionVariable('message', 'Username contains invalid characters.');
        } else {
            return true;
        }
        return false;
    }
}
