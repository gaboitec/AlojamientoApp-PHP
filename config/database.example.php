<?php
class DataBase {
    private $host = "localhost";
    private $database_name = "alojamientos";
    private $username = "your_username";
    private $password = "your_password";
    private $conn;

    public function get_connection(){
        $this->conn = null;
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->database_name, 
                                 $this->username, $this->password);
            $this->conn->exec("set names utf8");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception){
            echo "Database connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
} 