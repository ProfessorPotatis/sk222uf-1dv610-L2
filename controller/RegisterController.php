<?php

class RegisterController {

    private static $registerName = 'RegisterView::UserName';
	private static $registerPassword = 'RegisterView::Password';
	private static $register = 'RegisterView::Register';

    private $db;
    private $session;
    private $validator;

    private $username;
    private $password;
    private $passwordRepeat;
    private $message = '';
    
    public function __construct() {
        // ON PRODUCTION SERVER -> REMOVE SK222UF-1DV610-L2.
        require_once($_SERVER['DOCUMENT_ROOT'] . '/sk222uf-1dv610-L2/model/DBConfig.php');

        $this->db = new Database($db_host, $db_user, $db_password, $db_name);
        $this->session = new Session();
        $this->validator = new FormValidator();
    }

    public function handleUserRequest() {
        if ($_POST) {
            $this->handleRegisterRequest();
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

    private function handleRegisterRequest() {
        if (isset($_POST[self::$register])) {
            $inputIsValid = $this->validator->validateInputFields();
            $newUsername = $_REQUEST[self::$registerName];
            $newPassword = $_REQUEST[self::$registerPassword];
            $userExist = $this->db->checkIfUserExist($newUsername);
            if ($inputIsValid) {
                if ($userExist == false) {
                    $this->db->addUser($newUsername, $newPassword);
                } else {
                    $this->session->setSessionVariable('username', $_REQUEST[self::$registerName]);
                    $this->session->setSessionVariable('message', 'User exists, pick another username.');
                }
            }
        } else {
            $this->message = '';
        }
    }

    public function getMessage() {
        return $this->message;
    }

    public function getUsername() {
        return $this->username;
    }

    //TODO: FORMVALIDATOR.
    /*private function validateInputFields() {
        if (strlen($_REQUEST[self::$registerName]) < 3 && strlen($_REQUEST[self::$registerPassword]) < 6) {
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
        }
    }*/

    private function authenticateUser() {
        $this->isAuthenticated = $this->db->authenticate($_REQUEST[self::$registerName], $_REQUEST[self::$registerPassword]);

        if ($this->isAuthenticated) {
            $this->session->regenerateSessionId();
            $this->session->setSessionVariable('user_agent', $_SERVER['HTTP_USER_AGENT']);
            $this->session->setSessionVariable('loggedIn', true);
            $this->session->setSessionVariable('message', 'Welcome');
            
            $this->keepLoggedIn();
        } else {
            $this->session->setSessionVariable('username', $_REQUEST[self::$registerName]);
            $this->session->setSessionVariable('message', 'Wrong name or password');
        }
    }

    private function redirectToSelf() {
        header('Location: ' . $_SERVER['PHP_SELF'] . '?register');
    }
}