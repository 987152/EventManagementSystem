<?php
require_once '../config/db.php';

class Resource {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Add a new resource
    public function addResource($name, $type, $availability) {
        $sql = "INSERT INTO resources (name, type, availability) VALUES (:name, :type, :availability)";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':availability', $availability);
        return $stmt->execute();
    }

    // Get resource by ID
    public function getResourceById($resourceId) {
        $sql = "SELECT * FROM resources WHERE id = :id";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindParam(':id', $resourceId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get all resources
    public function getAllResources() {
        $sql = "SELECT * FROM resources";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Update resource information
    public function updateResource($resourceId, $name, $type, $availability) {
        $sql = "UPDATE resources SET name = :name, type = :type, availability = :availability WHERE id = :id";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindParam(':id', $resourceId);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':availability', $availability);
        return $stmt->execute();
    }

    // Delete a resource
    public function deleteResource($resourceId) {
        $sql = "DELETE FROM resources WHERE id = :id";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindParam(':id', $resourceId);
        return $stmt->execute();
    }
}
?>
