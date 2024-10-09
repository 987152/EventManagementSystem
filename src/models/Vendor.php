<?php
require_once '../config/db.php';

class Vendor {
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
        return $stmt->execute();
    }

    // Get vendor by ID
    public function getVendorById($vendorId) {
        $sql = "SELECT * FROM vendors WHERE id = :id";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindParam(':id', $vendorId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get all vendors for an event
    public function getVendorsByEvent($eventId) {
        $sql = "SELECT * FROM vendors WHERE event_id = :event_id";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindParam(':event_id', $eventId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Update vendor information
    public function updateVendor($vendorId, $name, $serviceType, $contactInfo) {
        $sql = "UPDATE vendors SET name = :name, service_type = :service_type, contact_info = :contact_info WHERE id = :id";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindParam(':id', $vendorId);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':service_type', $serviceType);
        $stmt->bindParam(':contact_info', $contactInfo);
        return $stmt->execute();
    }

    // Delete a vendor
    public function deleteVendor($vendorId) {
        $sql = "DELETE FROM vendors WHERE id = :id";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindParam(':id', $vendorId);
        return $stmt->execute();
    }
}
?>
