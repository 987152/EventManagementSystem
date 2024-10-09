<?php
require_once '../config/db.php';

class ResourceController {
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

        if ($stmt->execute()) {
            echo "Resource successfully added!";
        } else {
            echo "Error adding resource.";
        }
    }

    // Edit a resource
    public function editResource($resourceId, $name, $type, $availability) {
        $sql = "UPDATE resources SET name = :name, type = :type, availability = :availability WHERE id = :id";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindParam(':id', $resourceId);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':availability', $availability);

        if ($stmt->execute()) {
            echo "Resource successfully updated!";
        } else {
            echo "Error updating resource.";
        }
    }

    // Delete a resource
    public function deleteResource($resourceId) {
        $sql = "DELETE FROM resources WHERE id = :id";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindParam(':id', $resourceId);

        if ($stmt->execute()) {
            echo "Resource successfully deleted!";
        } else {
            echo "Error deleting resource.";
        }
    }

    // List all resources
    public function listResources() {
        $sql = "SELECT * FROM resources";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

$resourceController = new ResourceController();

$action = $_POST['action'] ?? '';

if ($action === 'addResource') {
    $name = $_POST['name'];
    $type = $_POST['type'];
    $availability = $_POST['availability'];
    $resourceController->addResource($name, $type, $availability);
}

if ($action === 'editResource') {
    $resourceId = $_POST['resourceId'];
    $name = $_POST['name'];
    $type = $_POST['type'];
    $availability = $_POST['availability'];
    $resourceController->editResource($resourceId, $name, $type, $availability);
}

if ($action === 'deleteResource') {
    $resourceId = $_POST['resourceId'];
    $resourceController->deleteResource($resourceId);
}
?>
