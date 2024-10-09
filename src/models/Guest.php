<?php
require_once '../config/db.php';

class Guest {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Add a new guest
    public function addGuest($name, $email, $rsvpStatus, $eventId) {
        $sql = "INSERT INTO guests (name, email, rsvp_status, event_id) VALUES (:name, :email, :rsvp_status, :event_id)";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':rsvp_status', $rsvpStatus);
        $stmt->bindParam(':event_id', $eventId);
        return $stmt->execute();
    }

    // Get guest by ID
    public function getGuestById($guestId) {
        $sql = "SELECT * FROM guests WHERE id = :id";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindParam(':id', $guestId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get all guests for an event
    public function getGuestsByEvent($eventId) {
        $sql = "SELECT * FROM guests WHERE event_id = :event_id";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindParam(':event_id', $eventId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Update guest information
    public function updateGuest($guestId, $name, $email, $rsvpStatus) {
        $sql = "UPDATE guests SET name = :name, email = :email, rsvp_status = :rsvp_status WHERE id = :id";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindParam(':id', $guestId);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':rsvp_status', $rsvpStatus);
        return $stmt->execute();
    }

    // Delete a guest
    public function deleteGuest($guestId) {
        $sql = "DELETE FROM guests WHERE id = :id";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindParam(':id', $guestId);
        return $stmt->execute();
    }
}
?>
