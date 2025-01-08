<?php
class DataBase
{
    private $host = "localhost";
    private $bd = "alojamientos";
    private $user = "root";
    private $password = "";
    private $conn;

    public function get_connection()
    {
        try {
            $this->conn = new PDO("mysql:host={$this->host};bdname={$this->bd}", $this->user, $this->password);
            $this->conn->exec("set names utf8");
        } catch (PDOException $error) {
            echo $error->getMessage();
        }

        return $this->conn;
    }
}
