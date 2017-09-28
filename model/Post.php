<?php

class Post {
    public function setPostVariable($name, $value) {
        $_POST[$name] = $value;
    }

    public function getPostVariable($postVariable) {
        if ($this->postVariableIsSet($postVariable)) {
            return $_POST[$postVariable];
        }
    }

    public function unsetPostVariable($postVariable) {
        unset($_POST[$postVariable]);
    }

    public function postVariableIsSet($postVariable) {
        return isset($_POST[$postVariable]);
    }
}