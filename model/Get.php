<?php

class Get {
    public function setGetVariable($name, $value) {
        $_GET[$name] = $value;
    }

    public function getGetVariable($getVariable) {
        if ($this->getVariableIsSet($getVariable)) {
            return $_GET[$getVariable];
        }
    }

    public function unsetGetVariable($getVariable) {
        unset($_GET[$getVariable]);
    }

    public function getVariableIsSet($getVariable) {
        return isset($_GET[$getVariable]);
    }
}