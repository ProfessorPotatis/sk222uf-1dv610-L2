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
    
    public function __construct() {
        // ON PRODUCTION SERVER -> REMOVE SK222UF-1DV610-L2.
        require_once($_SERVER['DOCUMENT_ROOT'] . '/sk222uf-1dv610-L2/model/DBConfig.php');

        $this->db = new Database($db_host, $db_user, $db_password, $db_name);
        $this->session = new Session();
    }

    public function handleUserRequest() {
        if ($_POST) {
            $this->handleLoginRequest();
        } else if (isset($_SESSION['message'])) {
            $this->message = $this->session->getSessionVariable('message');
            $this->session->unsetSessionVariable('message');
        } else {
            $this->message = '';
        }
    }

    private function handleLoginRequest() {
        if (isset($_POST[self::$logout])) {
            $this->logout();
        } else if (isset($_POST[self::$login])) {
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
        $this->isAuthenticated = $this->db->authenticate($_REQUEST[self::$providedUsername], $_REQUEST[self::$providedPassword]);

        if ($this->isAuthenticated) {
            $this->session->setSessionVariable('loggedIn', true);
            $this->session->setSessionVariable('message', 'Welcome');

            $this->redirectToSelf();
        } else {
            $this->message = 'Wrong name or password';
        }
    }

    private function logout() {
        if ($this->session->isLoggedIn()) {
            $this->session->unsetSessionVariable('loggedIn');

            $this->redirectToSelf();
        }
    }

    private function redirectToSelf() {
        header('Location: ' . $_SERVER['PHP_SELF']);
    }
}