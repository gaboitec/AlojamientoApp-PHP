<?php
require_once './config/database.php';
require_once './modules/models/User.php';

class UserController
{
    private $database;
    private $user;
    private $viewData = [];

    public function __construct()
    {
        $db = new DataBase();
        $this->database = $db->get_connection();
        $this->user = new User($this->database);
    }

    private function startSession($user) 
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        
        // Debug
        error_log("Session started for user: " . $user['username'] . " with role: " . $user['role']);
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            try {
                $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
                $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
                $password = $_POST['password'];
                
                // El registro normal siempre crea usuarios con rol 'user'
                if ($this->user->register($username, $email, $password)) {
                    header('Location: ./index.php?view=login&success=1');
                    exit();
                }
            } catch (Exception $error) {
                $this->viewData['error'] = "Registration failed: " . $error->getMessage();
            }
        }
        include './modules/views/auth/register.php';
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            try {
                $email = filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_EMAIL);
                $password = $_POST['contrasenia'];
                
                // Debug
                error_log("Login attempt with email: $email");
                
                $user = $this->user->login($email, $password);
                if ($user) {
                    // Debug
                    error_log("User found, role: " . $user['role']);
                    
                    $this->startSession($user);
                    
                    if ($user['role'] == "admin") {
                        error_log("Redirecting admin to showAcomodations");
                        header('Location: ./index.php?view=showAcomodations');
                    } else {
                        error_log("Redirecting user to home");
                        header('Location: ./index.php?view=home');
                    }
                    exit();
                } else {
                    error_log("Invalid credentials for email: $email");
                    $this->viewData['error'] = "Invalid credentials";
                    include './modules/views/auth/login.php';
                }
            } catch (Exception $error) {
                error_log("Login error: " . $error->getMessage());
                $this->viewData['error'] = "Login failed: " . $error->getMessage();
                include './modules/views/auth/login.php';
            }
        } else {
            include './modules/views/auth/login.php';
        }
    }

    public function profile()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ./index.php?view=login');
            exit();
        }

        try {
            $user = $this->user->getUserById($_SESSION['user_id']);
            $favorites = $this->user->getFavoriteAccommodations($_SESSION['user_id']);
            
            $this->viewData['user'] = $user;
            $this->viewData['favorites'] = $favorites;
            extract($this->viewData);
            include './modules/views/user/profile.php';
        } catch (Exception $e) {
            $this->viewData['error'] = "Error loading profile: " . $e->getMessage();
            extract($this->viewData);
            include './modules/views/user/profile.php';
        }
    }

    public function updateProfile()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ./index.php?view=login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            try {
                $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

                if ($this->user->updateUser($_SESSION['user_id'], $username, $email)) {
                    $this->viewData['success'] = "Profile updated successfully";
                }
            } catch (Exception $error) {
                $this->viewData['error'] = "Update failed: " . $error->getMessage();
            }
        }

        $user = $this->user->getUserById($_SESSION['user_id']);
        $this->viewData['user'] = $user;
        extract($this->viewData);
        include './modules/views/user/profile.php';
    }

    public function showUsers()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ./index.php?view=login');
            exit();
        }

        try {
            $users = $this->user->getAllUsers();
            $this->viewData['users'] = $users;
            extract($this->viewData);
            include './modules/views/user/ShowUsers.php';
        } catch (Exception $e) {
            $this->viewData['error'] = "Error loading users: " . $e->getMessage();
            extract($this->viewData);
            include './modules/views/user/ShowUsers.php';
        }
    }

    public function updateUser()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ./index.php?view=login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                $id = $_POST['id'];
                $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
                $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
                $role = $_POST['role'];

                if ($this->user->updateUserByAdmin($id, $username, $email, $role)) {
                    header('Location: ./index.php?view=showUsers&success=1');
                    exit();
                }
            } catch (Exception $e) {
                $this->viewData['error'] = "Update failed: " . $e->getMessage();
            }
        }

        $id = $_GET['id'] ?? null;
        if ($id) {
            $user = $this->user->getUserById($id);
            $this->viewData['userToEdit'] = $user;
            extract($this->viewData);
            include './modules/views/user/UpdateUser.php';
        }
    }

    public function logout()
    {
        session_start();
        session_destroy();
        header('Location: ./index.php');
        exit();
    }

    // Nuevo método para crear usuarios desde el admin
    public function createUser()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ./index.php?view=login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            try {
                $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
                $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
                $password = $_POST['password'];
                $role = $_POST['role'];

                if ($this->user->createUserByAdmin($username, $email, $password, $role)) {
                    header('Location: ./index.php?view=showUsers&success=1');
                    exit();
                }
            } catch (Exception $error) {
                $this->viewData['error'] = "User creation failed: " . $error->getMessage();
            }
        }
        include './modules/views/user/CreateUser.php';
    }

    public function deleteUser()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ./index.php?view=login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            try {
                $id = $_POST['id'];
                // No permitir eliminar el propio usuario admin
                if ($id == $_SESSION['user_id']) {
                    throw new Exception("You cannot delete your own admin account");
                }
                if ($this->user->delete($id)) {
                    header('Location: ./index.php?view=showUsers&success=1');
                    exit();
                }
            } catch (Exception $error) {
                $this->viewData['error'] = "Delete failed: " . $error->getMessage();
                $this->showUsers();
            }
        } else {
            header('Location: ./index.php?view=showUsers');
            exit();
        }
    }
}
