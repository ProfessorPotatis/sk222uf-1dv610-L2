<?php

class LoginController {

    private static $providedUsername = 'LoginView::UserName';
    private static $providedPassword = 'LoginView::Password';
    private static $logout = 'LoginView::Logout';
    private static $login = 'LoginView::Login';

    private $message = '';
    private $db;
    private $isAuthenticated = false;
    private $session;
    private $username;
    
    public function __construct() {
        // ON PRODUCTION SERVER -> REMOVE SK222UF-1DV610-L2.
        require_once($_SERVER['DOCUMENT_ROOT'] . '/sk222uf-1dv610-L2/model/DBConfig.php');

        $this->db = new Database($db_host, $db_user, $db_password, $db_name);
        $this->session = new Session();
    }

    public function handleUserRequest() {
        if ($_POST) {
            $this->handleLoginRequest();
            $this->redirectToSelf();
        } else if (isset($_SESSION['message'])) {
            $this->message = $this->session->getSessionVariable('message');
            $this->session->unsetSessionVariable('message');

            if (isset($_SESSION['username'])) {
                $this->username = $this->session->getSessionVariable('username');
                $this->session->unsetSessionVariable('username');
            }
        } else {
            $this->message = '';
        }
    }

    private function handleLoginRequest() {
        if (isset($_POST[self::$logout])) {
            $this->logout();
        } else if (isset($_POST[self::$login]) && $this->session->isLoggedIn() == false) {
            $this->validateInputFields();
        } else {
            $this->message = '';
        }
        //$this->redirectToSelf();
    }

    public function getMessage() {
        return $this->message;
    }

    public function getUsername() {
        return $this->username;
    }

    private function validateInputFields() {
        if ($_REQUEST[self::$providedUsername] == '') {
            $this->session->setSessionVariable('message', 'Username is missing');
        } else if ($_REQUEST[self::$providedPassword] == '') {
            $this->session->setSessionVariable('username', $_REQUEST[self::$providedUsername]);
            $this->session->setSessionVariable('message', 'Password is missing');
        } else {
            $this->authenticateUser();
        }
    }

    private function authenticateUser() {
        $this->isAuthenticated = $this->db->authenticate($_REQUEST[self::$providedUsername], $_REQUEST[self::$providedPassword]);

        if ($this->isAuthenticated) {
            $this->session->setSessionVariable('loggedIn', true);
            $this->session->setSessionVariable('message', 'Welcome');
        } else {
            $this->session->setSessionVariable('username', $_REQUEST[self::$providedUsername]);
            $this->session->setSessionVariable('message', 'Wrong name or password');
        }
    }

    private function logout() {
        if ($this->session->isLoggedIn()) {
            $this->session->unsetSessionVariable('loggedIn');
            $this->session->setSessionVariable('message', 'Bye bye!');
        } else {
            $this->message = '';
        }
    }

    private function redirectToSelf() {
        header('Location: ' . $_SERVER['PHP_SELF']);
    }
}