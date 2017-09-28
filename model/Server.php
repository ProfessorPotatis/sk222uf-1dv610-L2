<?php

class Server {
    public function setServerVariable($name, $value) {
        $_SERVER[$name] = $value;
    }

    public function getServerVariable($serverVariable) {
        if ($this->serverVariableIsSet($serverVariable)) {
            return $_SERVER[$serverVariable];
        }
    }

    public function unsetServerVariable($serverVariable) {
        unset($_SERVER[$serverVariable]);
    }

    public function serverVariableIsSet($serverVariable) {
        return isset($_SERVER[$serverVariable]);
    }
}