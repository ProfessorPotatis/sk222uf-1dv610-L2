<?php

class Cookie {
    public function setCookieVariable($name, $value) {
        $_COOKIE[$name] = $value;
    }

    public function getCookieVariable($cookieVariable) {
        if ($this->cookieIsSet($cookieVariable)) {
            return $_COOKIE[$cookieVariable];
        }
    }

    public function unsetCookieVariable($cookieVariable) {
        unset($_COOKIE[$cookieVariable]);
    }

    public function cookieIsSet($cookieVariable) {
        return isset($_COOKIE[$cookieVariable]);
    }
}