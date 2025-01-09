<?php
class DataBase {
    private $host = "localhost";
    private $database_name = "booking";
    private $username = "root";
    private $password = "root";
    private $conn;

    public function get_connection(){
        try {
            if ($this->conn === null) {
                $this->conn = new PDO(
                    "mysql:host=" . $this->host . ";dbname=" . $this->database_name, 
                    $this->username, 
                    $this->password,
                    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
                );
                error_log("Database connected successfully");
                $this->conn->exec("set names utf8");
            }
            return $this->conn;
        } catch(PDOException $e) {
            error_log("Connection Error: " . $e->getMessage());
            throw new Exception("Database connection failed");
        }
    }
} 