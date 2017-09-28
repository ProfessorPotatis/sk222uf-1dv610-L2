<?php

class Get {
    public function getVariableIsSet($getVariable) {
        return isset($_GET[$getVariable]);
    }

    public function setGetVariable($name, $value) {
        $_GET[$name] = $value;
    }

    public function getGetVariable($getVariable) {
        return $_GET[$getVariable];
    }

    public function unsetGetVariable($getVariable) {
        unset($_GET[$getVariable]);
    }
}