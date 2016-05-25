<?php

class Login {
    protected static $instance;

    protected function __construct() {        
    }

    protected function __clone() {        
    }
    
    public static function getInstance() {
        if (!isset(self::$instance)) { 
            self::$instance = new self; 
        }

        return self::$instance;
    }
    
    function check_password($login, $password) {
        if ($login == ADMIN_LOGIN && $password == ADMIN_PASSWORD) {
            return true;
        }
        return false;
    }

    function is_authenticated() {
        if (isset($_SESSION['authenticated']) && $_SESSION['authenticated']) {
            return true;
        }
        return false;
    }

    function set_authenticated() {
        $_SESSION['authenticated'] = true;
    }

}
