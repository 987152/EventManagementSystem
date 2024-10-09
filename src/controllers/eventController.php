<?php
require_once '../config/db.php';

class GuestController {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Add a new guest
    public function addGuest($name, $email, $rsvp) {
        $sql = "INSERT INTO guests (name, email, rsvp_status) VALUES (:name, :email, :rsvp)";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':rsvp', $rsvp);

        if ($stmt->execute()) {
            echo "Guest added successfully!";
        } else {
            echo "Error adding guest.";
        }
    }

    // Delete a guest
    public function deleteGuest($guestId) {
        $sql = "DELETE FROM guests WHERE id = :id";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindParam(':id', $guestId);

        if ($stmt->execute()) {
            echo "Guest deleted successfully!";
        } else {
            echo "Error deleting guest.";
        }
    }

    // Edit guest details
    public function editGuest($guestId, $name, $email, $rsvp) {
        $sql = "UPDATE guests SET name = :name, email = :email, rsvp_status = :rsvp WHERE id = :id";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindParam(':id', $guestId);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':rsvp', $rsvp);

        if ($stmt->execute()) {
            echo "Guest details updated!";
        } else {
            echo "Error updating guest.";
        }
    }

    // List all guests
    public function listGuests() {
        $sql = "SELECT * FROM guests";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

$guestController = new GuestController();

$action = $_POST['action'] ?? '';

if ($action === 'addGuest') {
    $name = $_POST['guestName'];
    $email = $_POST['guestEmail'];
    $rsvp = $_POST['rsvpStatus'];
    $guestController->addGuest($name, $email, $rsvp);
}
