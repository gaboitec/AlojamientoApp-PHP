<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    session_start();
    require_once './config/database.php';
    require_once './modules/controllers/UserController.php';
    require_once './modules/controllers/AccommodationController.php';
    require_once './modules/controllers/HomeController.php';

    $userController = new UserController();
    $accommodationController = new AccommodationController();
    $homeController = new HomeController();

    // Route handling
    $action = $_GET['action'] ?? '';
    $view = $_GET['view'] ?? '';

    // Handle actions
    if (!empty($action)) {
        switch ($action) {
            case 'login':
                $userController->login();
                break;
            case 'register':
                $userController->register();
                break;
            case 'updateProfile':
                $userController->updateProfile();
                break;
            case 'create':
                $accommodationController->create();
                break;
            case 'update':
                $accommodationController->update();
                break;
            case 'addToFavorites':
                $accommodationController->addToFavorites();
                break;
            case 'removeFromFavorites':
                $accommodationController->removeFromFavorites();
                break;
            case 'updateUser':
                $userController->updateUser();
                break;
            case 'logout':
                $userController->logout();
                break;
            case 'deleteAccommodation':
                $accommodationController->deleteAccommodation();
                break;
            case 'createUser':
                if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'admin') {
                    $userController->createUser();
                } else {
                    header('Location: ./index.php');
                    exit();
                }
                break;
            case 'deleteUser':
                if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'admin') {
                    $userController->deleteUser();
                } else {
                    header('Location: ./index.php');
                    exit();
                }
                break;
            default:
                throw new Exception("Invalid action");
        }
    } else {
        // Handle views
        switch ($view) {
            case '':
            case 'home':
                $homeController->index();
                break;
            case 'login':
                include './modules/views/auth/login.php';
                break;
            case 'register':
                include './modules/views/auth/register.php';
                break;
            case 'profile':
                $userController->profile();
                break;
            case 'createAcomodation':
                include './modules/views/acomodations/CreateAcomodation.php';
                break;
            case 'updateAcomodation':
                $id = $_GET['id'] ?? null;
                if ($id) {
                    $accommodationController->getById($id);
                } else {
                    header('Location: ./index.php?view=showAcomodations');
                    exit();
                }
                break;
            case 'showAcomodations':
                $accommodationController->index();
                break;
            case 'showUsers':
                $userController->showUsers();
                break;
            case 'updateUser':
                $userController->updateUser();
                break;
            case 'createUser':
                if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'admin') {
                    include './modules/views/user/CreateUser.php';
                } else {
                    header('Location: ./index.php');
                    exit();
                }
                break;
            default:
                include './modules/views/home.php';
        }
    }
} catch (Exception $e) {
    error_log($e->getMessage());
    include './modules/views/error.php';
}
