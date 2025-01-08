<?php
require_once './config/database.php';
require_once './modules/models/User.php';

class UserController
{
    private $database;
    private $user;

    public function __construct()
    {
        $db = new DataBase();
        $this->database = $db->get_connection();
        $this->user = new User($this->database);
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $user_email = $_POST['correo'];
            $user_password = $_POST['contrasenia'];

            try {
                $data = $this->user->login($user_email, $user_password);
                $user = $data->fetch(PDO::FETCH_ASSOC);

                if ($user['role'] == "admin")
                    header('Location: ./modules/views/acomodations/ShowAcomodation.php');
                else if ($user['role'] == "user")
                    header('Location: ./modules/views/home.php');
            } catch (Exception $error) {
                echo "usuario o contrasenia incorrectos";
            }
        } else include './modules/views/auth/login.php';
    }
}
