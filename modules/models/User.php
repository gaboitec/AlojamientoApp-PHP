<?php
class User
{
    private $id;
    private $username;
    private $email;
    private $password;
    private $role;
    private $created;

    private $table_name = "users";

    public function __construct(private $connection) {}

    public function register($username, $email, $password)
    {
        try {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $query = "INSERT INTO {$this->table_name} (username, email, password, role) 
                     VALUES (:username, :email, :password, 'user')";
            
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashed_password);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Registration failed: " . $e->getMessage());
        }
    }

    public function getUserById($id)
    {
        $query = "SELECT id, username, email, role, created FROM {$this->table_name} WHERE id = :id";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateUser($id, $username, $email)
    {
        $query = "UPDATE {$this->table_name} 
                 SET username = :username, email = :email 
                 WHERE id = :id";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        return $stmt->execute();
    }

    public function saveAccommodationToFavorites($user_id, $accommodation_id)
    {
        $query = "INSERT INTO user_favorites (user_id, accommodation_id) 
                 VALUES (:user_id, :accommodation_id)";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':accommodation_id', $accommodation_id);
        return $stmt->execute();
    }

    public function removeFavoriteAccommodation($user_id, $accommodation_id)
    {
        $query = "DELETE FROM user_favorites 
                 WHERE user_id = :user_id AND accommodation_id = :accommodation_id";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':accommodation_id', $accommodation_id);
        return $stmt->execute();
    }

    public function login($email, $password)
    {
        try {
            $query = "SELECT * FROM {$this->table_name} WHERE email = :email";
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($user) {
                // For testing, print the values (remove in production)
                error_log("Login attempt - Email: $email, Role: " . $user['role']);
                
                // For now, since we're using plain text password in data.sql
                if ($password === $user['password']) {
                    return $user;
                }
            }
            return false;
        } catch (PDOException $e) {
            error_log("Login error: " . $e->getMessage());
            throw new Exception("Login failed");
        }
    }

    public function getFavoriteAccommodations($user_id)
    {
        try {
            $query = "SELECT a.* FROM accommodations a 
                      INNER JOIN user_favorites uf ON a.id = uf.accommodation_id 
                      WHERE uf.user_id = :user_id";
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting favorites: " . $e->getMessage());
            return [];
        }
    }

    public function getAllUsers()
    {
        $query = "SELECT id, username, email, role, created FROM {$this->table_name}";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateUserByAdmin($id, $username, $email, $role)
    {
        $query = "UPDATE {$this->table_name} 
                 SET username = :username, email = :email, role = :role 
                 WHERE id = :id";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':role', $role);
        return $stmt->execute();
    }

    public function createUserByAdmin($username, $email, $password, $role)
    {
        try {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $query = "INSERT INTO {$this->table_name} (username, email, password, role) 
                     VALUES (:username, :email, :password, :role)";
            
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashed_password);
            $stmt->bindParam(':role', $role);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("User creation failed: " . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            // Primero eliminar los favoritos del usuario
            $query = "DELETE FROM user_favorites WHERE user_id = :id";
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            
            // Luego eliminar el usuario
            $query = "DELETE FROM {$this->table_name} WHERE id = :id";
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error deleting user: " . $e->getMessage());
            throw new Exception("Failed to delete user");
        }
    }
}
