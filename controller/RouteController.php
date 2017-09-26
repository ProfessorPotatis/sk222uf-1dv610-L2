<?php

class RouteController {
    private $layoutView;
    private $dateTimeView;
    private $loginView;
    private $registerView;

    private $session;

    public function __construct() {
        $this->layoutView = new LayoutView();
        $this->dateTimeView = new dateTimeView();
        $this->loginView = new LoginView();
        $this->registerView = new RegisterView();

        $this->session = new Session();
    }

    public function route() {
        if ($this->session->isLoggedIn()) {
            $isLoggedIn = $this->checkUserAgent();
            $this->renderLoginPage($isLoggedIn);
        } else if ($this->userWantsToRegister()) {
            $isLoggedIn = false;
            $this->renderRegisterPage($isLoggedIn);
        } else if ($this->userHasCookies()) {
            $isLoggedIn = true;
            $this->renderLoginPage($isLoggedIn);
		} else {
            $isLoggedIn = false;
            $this->renderLoginPage($isLoggedIn);
        }
    }

    private function checkUserAgent() {
        $stayLoggedIn;
        if (!empty($_SESSION['user_agent']) && $this->session->getSessionVariable('user_agent') !== $_SERVER['HTTP_USER_AGENT']) {
            $stayLoggedIn = false;
        } else {
            $stayLoggedIn = true;
        }
        return $stayLoggedIn;
    }

    private function renderLoginPage($isLoggedIn) {
        $this->layoutView->render($isLoggedIn, $this->loginView, $this->dateTimeView);
    }

    private function userWantsToRegister() {
        return isset($_GET['register']);
    }

    private function renderRegisterPage($isLoggedIn) {
        $this->layoutView->render($isLoggedIn, $this->registerView, $this->dateTimeView);
    }

    private function userHasCookies() {
        return isset($_COOKIE['LoginView::CookiePassword']) && !empty($_COOKIE['LoginView::CookiePassword']);
    }
}