<?php

class RouteController {
    private $layoutView;
    private $loginView;
    private $dateTimeView;

    private $session;

    public function __construct() {
        $this->layoutView = new LayoutView();
        $this->loginView = new LoginView();
        $this->dateTimeView = new dateTimeView();

        $this->session = new Session();
    }

    public function route() {
        $isLoggedIn;

        if ($this->session->isLoggedIn()) {
            $isLoggedIn = true;
        } else {
            $isLoggedIn = false;
        }

        $this->renderLoginPage($isLoggedIn);
    }

    private function renderLoginPage($isLoggedIn) {
        $this->layoutView->render($isLoggedIn, $this->loginView, $this->dateTimeView);
    }
}