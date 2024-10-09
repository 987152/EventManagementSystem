<?php
require_once '../config/db.php';

class VendorController {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Add a new vendor
    public function addVendor($name, $serviceType, $contactInfo, $eventId) {
        $sql = "INSERT INTO vendors (name, service_type, contact_info, event_id) VALUES (:name, :service_type, :contact_info, :event_id)";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':service_type', $serviceType);
        $stmt->bindParam(':contact_info', $contactInfo);
        $stmt->bindParam(':event_id', $eventId);

        if ($stmt->execute()) {
            echo "Vendor successfully added!";
        } else {
            echo "Error adding vendor.";
        }
    }

    // Edit a vendor
    public function editVendor($vendorId, $name, $serviceType, $contactInfo) {
        $sql = "UPDATE vendors SET name = :name, service_type = :service_type, contact_info = :contact_info WHERE id = :id";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindParam(':id', $vendorId);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':service_type', $serviceType);
        $stmt->bindParam(':contact_info', $contactInfo);

        if ($stmt->execute()) {
            echo "Vendor successfully updated!";
        } else {
            echo "Error updating vendor.";
        }
    }

    // Delete a vendor
    public function deleteVendor($vendorId) {
        $sql = "DELETE FROM vendors WHERE id = :id";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindParam(':id', $vendorId);

        if ($stmt->execute()) {
            echo "Vendor successfully deleted!";
        } else {
            echo "Error deleting vendor.";
        }
    }

    // List all vendors for an event
    public function listVendors($eventId) {
        $sql = "SELECT * FROM vendors WHERE event_id = :event_id";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindParam(':event_id', $eventId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

$vendorController = new VendorController();

$action = $_POST['action'] ?? '';

if ($action === 'addVendor') {
    $name = $_POST['name'];
    $serviceType = $_POST['serviceType'];
    $contactInfo = $_POST['contactInfo'];
    $eventId = $_POST['eventId'];
    $vendorController->addVendor($name, $serviceType, $contactInfo, $eventId);
}

if ($action === 'editVendor') {
    $vendorId = $_POST['vendorId'];
    $name = $_POST['name'];
    $serviceType = $_POST['serviceType'];
    $contactInfo = $_POST['contactInfo'];
    $vendorController->editVendor($vendorId, $name, $serviceType, $contactInfo);
}

if ($action === 'deleteVendor') {
    $vendorId = $_POST['vendorId'];
    $vendorController->deleteVendor($vendorId);
}
?>
