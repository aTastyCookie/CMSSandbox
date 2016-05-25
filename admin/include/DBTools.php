<?php

class DBTools {

    protected static $instance;

    private $conn;
    
    protected function __construct() {
        $this->conn = new mysqli(DB_HOST,DB_USER,DB_PASSWORD) or
                    die('Cannot connect to the database, please check your config file.');
    }

    static public function sanitizeString($str) {
        $conn = DBTools::getInstance()->getConnection();
	if (get_magic_quotes_gpc()) {
		$sanitize = $conn->real_escape_string(stripslashes($str));	 
	} else {
		$sanitize = $conn->real_escape_string($str);	
	} 
	return $sanitize;
}

// Constructeur en privé.

    protected function __clone() {        
    }
    
    public function getConnection(){
        return $this->conn;
    }

    public static function getInstance() {
        if (!isset(self::$instance)) { 
            self::$instance = new self; 
        }

        return self::$instance;
    }
}
