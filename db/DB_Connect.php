<?php
class DB_Connect {
    private $conn;
 
    public function connect() {
        //require_once 'Config.php';
         define("DB_HOST", "127.0.0.1:3307");
define("DB_USER", "root");
define("DB_PASSWORD", "");
define("DB_DATABASE", "register");
        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
         
        return $this->conn;
    }
}
 
?>