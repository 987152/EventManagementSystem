<?php
require_once '../config/db.php';

class GuestController {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Add a new guest
    public function addGuest($name, $email, $rsvp, $eventId) {
        $sql = "INSERT INTO guests (name, email, rsvp_status, event_id) VALUES (:name, :email, :rsvp, :eventId)";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':rsvp', $rsvp);
        $stmt->bindParam(':eventId', $eventId);

        if ($stmt->execute()) {
            echo "Guest successfully added!";
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
            echo "Guest successfully deleted!";
        } else {
            echo "Error deleting guest.";
        }
    }

    // Edit guest details
    public function editGuest($guestId, $name, $email, $rsvp, $eventId) {
        $sql = "UPDATE guests SET name = :name, email = :email, rsvp_status = :rsvp, event_id = :eventId WHERE id = :id";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindParam(':id', $guestId);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':rsvp', $rsvp);
        $stmt->bindParam(':eventId', $eventId);

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
    $eventId = 1;  // Make sure this input exists in your form
    $guestController->addGuest($name, $email, $rsvp, $eventId);
}
?>