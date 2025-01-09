<?php
require_once './config/database.php';
require_once './modules/models/Accommodation.php';
require_once './modules/models/User.php';

class AccommodationController
{
    private $database;
    private $accommodation;
    private $viewData = [];

    public function __construct()
    {
        $db = new DataBase();
        $this->database = $db->get_connection();
        $this->accommodation = new Accommodation($this->database);
    }

    public function index()
    {
        try {
            error_log("Starting index method");
            
            // Debug database connection and table contents
            if ($this->database) {
                error_log("Database connection exists");
                
                try {
                    // Check if table exists
                    $tables = $this->database->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
                    error_log("Available tables: " . print_r($tables, true));
                    
                    // Check if accommodations table exists
                    if (!in_array('accommodations', $tables)) {
                        error_log("Accommodations table not found! Available tables: " . implode(', ', $tables));
                        throw new Exception("Accommodations table not found");
                    }
                    
                    // Direct query to check table contents
                    $stmt = $this->database->query("SELECT * FROM accommodations");
                    $direct_results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    error_log("Direct query results count: " . count($direct_results));
                    error_log("Direct query results: " . print_r($direct_results, true));
                    
                    // Set the results directly to viewData
                    $this->viewData['accommodations'] = $direct_results;
                    
                    if (empty($direct_results)) {
                        error_log("No records found in accommodations table");
                        $this->insertTestData();
                        // Get fresh data after insertion
                        $stmt = $this->database->query("SELECT * FROM accommodations");
                        $this->viewData['accommodations'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    }
                } catch (PDOException $e) {
                    error_log("Database query error: " . $e->getMessage());
                    throw $e;
                }
            } else {
                error_log("WARNING: Database connection is null!");
            }
            
            // Pass viewData to the view
            extract($this->viewData);
            include './modules/views/acomodations/ShowAcomodations.php';
        } catch (Exception $e) {
            error_log("Error in index method: " . $e->getMessage() . "\n" . $e->getTraceAsString());
            $this->viewData['error'] = "Failed to load accommodations: " . $e->getMessage();
            extract($this->viewData);
            include './modules/views/acomodations/ShowAcomodations.php';
        }
    }

    private function insertTestData()
    {
        try {
            $testData = [
                [
                    'name' => 'Hotel Paradise',
                    'location' => 'Beach City',
                    'price' => 150.00,
                    'description' => 'Luxury hotel near the beach.',
                    'image_url' => 'https://images.pexels.com/photos/3935311/pexels-photo-3935311.jpeg'
                ],
                [
                    'name' => 'Mountain Escape',
                    'location' => 'Highlands',
                    'price' => 90.00,
                    'description' => 'Cozy cabin with mountain views.',
                    'image_url' => 'https://images.pexels.com/photos/3935348/pexels-photo-3935348.jpeg'
                ]
            ];

            foreach ($testData as $data) {
                $this->accommodation->create(
                    $data['name'],
                    $data['location'],
                    $data['price'],
                    $data['description'],
                    $data['image_url']
                );
            }
            error_log("Test data inserted successfully");
        } catch (Exception $e) {
            error_log("Error inserting test data: " . $e->getMessage());
        }
    }

    public function create()
    {
        session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ./index.php?view=login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            try {
                $image_url = $this->handleImageUpload();
                
                $result = $this->accommodation->create(
                    $_POST['nombre'],
                    $_POST['ubicacion'],
                    $_POST['precio'],
                    $_POST['descripcion'],
                    $image_url
                );

                if ($result) {
                    header('Location: ./index.php?view=showAcomodations&success=1');
                    exit();
                }
            } catch (Exception $error) {
                $this->viewData['error'] = "Failed to create accommodation: " . $error->getMessage();
            }
        }
        include './modules/views/acomodations/CreateAcomodation.php';
    }

    public function update()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ./index.php?view=login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            try {
                $image_url = isset($_FILES['imagen']) && $_FILES['imagen']['error'] !== UPLOAD_ERR_NO_FILE ? 
                    $this->handleImageUpload() : 
                    $_POST['current_image'];

                $result = $this->accommodation->update(
                    $_POST['id'],
                    $_POST['nombre'],
                    $_POST['ubicacion'],
                    $_POST['precio'],
                    $_POST['descripcion'],
                    $image_url
                );

                if ($result) {
                    header('Location: ./index.php?view=showAcomodations&success=1');
                    exit();
                }
            } catch (Exception $error) {
                $this->viewData['error'] = "Update failed: " . $error->getMessage();
                $this->viewData['accommodation'] = $this->accommodation->getById($_POST['id']);
                extract($this->viewData);
                include './modules/views/acomodations/UpdateAcomodation.php';
                return;
            }
        }

        $id = $_GET['id'] ?? null;
        if ($id) {
            try {
                $accommodation = $this->accommodation->getById($id);
                if (!$accommodation) {
                    throw new Exception("Accommodation not found");
                }
                $this->viewData['accommodation'] = $accommodation;
                extract($this->viewData);
                include './modules/views/acomodations/UpdateAcomodation.php';
            } catch (Exception $e) {
                $this->viewData['error'] = $e->getMessage();
                header('Location: ./index.php?view=showAcomodations&error=' . urlencode($e->getMessage()));
                exit();
            }
        } else {
            header('Location: ./index.php?view=showAcomodations');
            exit();
        }
    }

    private function handleImageUpload()
    {
        if (!isset($_FILES['imagen']) || $_FILES['imagen']['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("Image upload failed");
        }

        $upload_dir = './public/uploads/';
        $file_extension = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
        $file_name = uniqid() . '.' . $file_extension;
        $file_path = $upload_dir . $file_name;

        if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $file_path)) {
            throw new Exception("Failed to save image");
        }

        return $file_path;
    }

    public function addToFavorites()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: ./index.php?view=login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            try {
                $accommodation_id = $_POST['accommodation_id'];
                $user = new User($this->database);
                $user->saveAccommodationToFavorites($_SESSION['user_id'], $accommodation_id);
                header('Location: ./index.php?view=profile&success=1');
                exit();
            } catch (Exception $error) {
                $this->viewData['error'] = "Failed to add to favorites";
            }
        }
    }

    public function removeFromFavorites()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: ./index.php?view=login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            try {
                $accommodation_id = $_POST['accommodation_id'];
                $user = new User($this->database);
                $user->removeFavoriteAccommodation($_SESSION['user_id'], $accommodation_id);
                header('Location: ./index.php?view=profile&success=1');
                exit();
            } catch (Exception $error) {
                $this->viewData['error'] = "Failed to remove from favorites";
            }
        }
    }

    public function getById($id)
    {
        try {
            $accommodation = $this->accommodation->getById($id);
            if (!$accommodation) {
                throw new Exception("Accommodation not found");
            }
            $this->viewData['accommodation'] = $accommodation;
            extract($this->viewData);
            include './modules/views/acomodations/UpdateAcomodation.php';
        } catch (Exception $e) {
            $this->viewData['error'] = $e->getMessage();
            extract($this->viewData);
            include './modules/views/acomodations/ShowAcomodations.php';
        }
    }

    public function deleteAccommodation()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: ./index.php?view=login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            try {
                $id = $_POST['id'];
                if ($this->accommodation->delete($id)) {
                    header('Location: ./index.php?view=showAcomodations&success=1');
                    exit();
                }
            } catch (Exception $error) {
                $this->viewData['error'] = "Delete failed: " . $error->getMessage();
                extract($this->viewData);
                include './modules/views/acomodations/ShowAcomodations.php';
            }
        } else {
            header('Location: ./index.php?view=showAcomodations');
            exit();
        }
    }
} 