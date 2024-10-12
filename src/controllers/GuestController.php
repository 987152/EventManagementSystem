<?php
require_once '../src/config/db.php';

class GuestController {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Add a new guest
    public function addGuest($name, $email, $rsvp, $event_id) {
        $sql = "INSERT INTO guests (name, email, rsvp_status, event_id) VALUES (:name, :email, :rsvp_status, :event_id)";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':rsvp_status', $rsvp);
        $stmt->bindParam(':event_id', $event_id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Edit a guest
    public function editGuest($id, $name, $email, $rsvp, $event_id) {
        $sql = "UPDATE guests SET name = :name, email = :email, rsvp_status = :rsvp_status, event_id = :event_id WHERE id = :id";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':rsvp_status', $rsvp);
        $stmt->bindParam(':event_id', $event_id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    // Delete a guest
    public function deleteGuest($id) {
        $sql = "DELETE FROM guests WHERE id = :id";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // List all guests
    public function listGuests() {
        $sql = "SELECT guests.*, events.name as event_name FROM guests JOIN events ON guests.event_id = events.id";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
