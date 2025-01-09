<?php
require_once './config/database.php';
require_once './modules/models/Accommodation.php';
require_once './modules/models/User.php';

class HomeController
{
    private $database;
    private $accommodation;
    private $user;
    private $viewData = [];

    public function __construct()
    {
        $db = new DataBase();
        $this->database = $db->get_connection();
        $this->accommodation = new Accommodation($this->database);
        $this->user = new User($this->database);
    }

    public function index()
    {
        try {
            // Obtener todos los alojamientos
            $accommodations = $this->accommodation->getAll();
            $this->viewData['accommodations'] = $accommodations;

            // Obtener favoritos si el usuario está logueado
            if (isset($_SESSION['user_id'])) {
                $favorites = $this->user->getFavoriteAccommodations($_SESSION['user_id']);
                $this->viewData['userFavorites'] = array_column($favorites, 'id');
            }

            extract($this->viewData);
            include './modules/views/home.php';
        } catch (Exception $e) {
            $this->viewData['error'] = $e->getMessage();
            extract($this->viewData);
            include './modules/views/home.php';
        }
    }
} 