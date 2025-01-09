<?php
class Accommodation
{
    private $table_name = "accommodations";

    public function __construct(private $connection) {}

    public function create($name, $location, $price, $description, $image_url)
    {
        $query = "INSERT INTO {$this->table_name} 
                 (name, location, price, description, image_url) 
                 VALUES (:name, :location, :price, :description, :image_url)";
        
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':location', $location);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':image_url', $image_url);
        
        return $stmt->execute();
    }

    public function getAll()
    {
        try {
            // Debug table name
            error_log("Table name: {$this->table_name}");
            
            $query = "SELECT * FROM {$this->table_name}";
            error_log("Executing query: " . $query);
            
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Debug results
            error_log("Query results: " . print_r($results, true));
            
            return $results;
        } catch (PDOException $e) {
            error_log("Error in getAll: " . $e->getMessage());
            throw new Exception("Failed to fetch accommodations");
        }
    }

    public function update($id, $name, $location, $price, $description, $image_url)
    {
        $query = "UPDATE {$this->table_name} 
                 SET name = :name, location = :location, 
                     price = :price, description = :description, 
                     image_url = :image_url 
                 WHERE id = :id";
                 
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':location', $location);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':image_url', $image_url);
        
        return $stmt->execute();
    }

    public function getUserFavorites($user_id)
    {
        $query = "SELECT a.* FROM {$this->table_name} a 
                 INNER JOIN user_favorites uf ON a.id = uf.accommodation_id 
                 WHERE uf.user_id = :user_id";
        $stmt = $this->connection->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        try {
            $query = "SELECT * FROM {$this->table_name} WHERE id = :id";
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$result) {
                throw new Exception("Accommodation not found");
            }
            return $result;
        } catch (PDOException $e) {
            error_log("Error getting accommodation: " . $e->getMessage());
            throw new Exception("Error getting accommodation details");
        }
    }

    public function delete($id)
    {
        try {
            // Primero verificar si existe
            $accommodation = $this->getById($id);
            
            // Eliminar el archivo de imagen si existe y no es una URL externa
            if (!empty($accommodation['image_url']) && file_exists($accommodation['image_url'])) {
                unlink($accommodation['image_url']);
            }
            
            // Eliminar registros relacionados en user_favorites
            $query = "DELETE FROM user_favorites WHERE accommodation_id = :id";
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            
            // Eliminar el alojamiento
            $query = "DELETE FROM {$this->table_name} WHERE id = :id";
            $stmt = $this->connection->prepare($query);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Error deleting accommodation: " . $e->getMessage());
            throw new Exception("Failed to delete accommodation");
        }
    }
}
