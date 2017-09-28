<?php

class Request {
    public function setRequestVariable($name, $value) {
        $_REQUEST[$name] = $value;
    }

    public function getRequestVariable($requestVariable) {
        if ($this->requestVariableIsSet($requestVariable)) {
            return $_REQUEST[$requestVariable];
        }
    }

    public function unsetRequestVariable($requestVariable) {
        unset($_REQUEST[$requestVariable]);
    }

    public function requestVariableIsSet($requestVariable) {
        return isset($_REQUEST[$requestVariable]);
    }
}