<?php

class Server {
    public function setServerVariable($name, $value) {
        $_SERVER[$name] = $value;
    }

    public function getServerVariable($serverVariable) {
        return $_SERVER[$serverVariable];
    }

    public function unsetServerVariable($serverVariable) {
        unset($_SERVER[$serverVariable]);
    }
}