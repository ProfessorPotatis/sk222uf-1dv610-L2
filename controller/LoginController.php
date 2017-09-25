<?php

class LoginController {

    private static $providedUsername = 'LoginView::UserName';
    private static $providedPassword = 'LoginView::Password';
    private static $logout = 'LoginView::Logout';
    private static $login = 'LoginView::Login';
    private static $keep = 'LoginView::KeepMeLoggedIn';
    private static $cookieName = 'LoginView::CookieName';
	private static $cookiePassword = 'LoginView::CookiePassword';

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
        } else if (isset($_COOKIE[self::$cookiePassword]) && !$this->session->isLoggedIn()) {
            if ($this->db->verifyCookie($_COOKIE[self::$cookieName], $_COOKIE[self::$cookiePassword])) {
                $this->session->setSessionVariable('message', 'Welcome back with cookie');
                $this->session->setSessionVariable('loggedIn', true);
                $this->message = $this->session->getSessionVariable('message');
                $this->session->unsetSessionVariable('message');
            } else {
                $this->session->setSessionVariable('message', 'Wrong information in cookies');
                $this->session->unsetSessionVariable('loggedIn');
                $this->clearCookies();
                $this->redirectToSelf();
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
            $this->session->regenerateSessionId();
            $this->session->setSessionVariable('user_agent', $_SERVER['HTTP_USER_AGENT']);
            $this->session->setSessionVariable('loggedIn', true);
            $this->session->setSessionVariable('message', 'Welcome');
            
            $this->keepLoggedIn();
        } else {
            $this->session->setSessionVariable('username', $_REQUEST[self::$providedUsername]);
            $this->session->setSessionVariable('message', 'Wrong name or password');
        }
    }

    private function logout() {
        if ($this->session->isLoggedIn()) {
            $this->clearCookies();
            $this->session->unsetSessionVariable('loggedIn');
            $this->session->setSessionVariable('message', 'Bye bye!');
        } else {
            $this->message = '';
        }
    }

    private function redirectToSelf() {
        header('Location: ' . $_SERVER['PHP_SELF']);
    }

    private function keepLoggedIn() {
        if (isset($_POST[self::$keep])) {
            $this->session->setSessionVariable('message', 'Welcome and you will be remembered');
            $this->setCookies();
        }
    }

    private function setCookies() {
        $randomStr = uniqid();
        setcookie(self::$cookieName, $_REQUEST[self::$providedUsername], time() + (86400 * 30), '/');
        setcookie(self::$cookiePassword, $randomStr, time() + (86400 * 30), '/');

        $this->saveCookiesToDatabase($randomStr);
    }

    private function saveCookiesToDatabase($randomStr) {
        $this->db->saveUserCookie($_REQUEST[self::$providedUsername], $randomStr);
    }

    private function clearCookies() {
        if (isset($_COOKIE[self::$cookieName])) {
            unset($_COOKIE[self::$cookieName]);
            setcookie(self::$cookieName, '', time() - 3600, '/'); // empty value and old timestamp, to delete cookie
        }

        if (isset($_COOKIE[self::$cookiePassword])) {
            unset($_COOKIE[self::$cookiePassword]);
            setcookie(self::$cookiePassword, '', time() - 3600, '/'); // empty value and old timestamp, to delete cookie
        }
    }
}