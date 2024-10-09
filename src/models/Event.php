<?php
require_once '../config/db.php';

class Event {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Create a new event
    public function createEvent($name, $date, $time, $description) {
        $sql = "INSERT INTO events (name, date, time, description) VALUES (:name, :date, :time, :description)";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':time', $time);
        $stmt->bindParam(':description', $description);
        return $stmt->execute();
    }

    // Get event by ID
    public function getEventById($eventId) {
        $sql = "SELECT * FROM events WHERE id = :id";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindParam(':id', $eventId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get all events
    public function getAllEvents() {
        $sql = "SELECT * FROM events";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Update an event
    public function updateEvent($eventId, $name, $date, $time, $description) {
        $sql = "UPDATE events SET name = :name, date = :date, time = :time, description = :description WHERE id = :id";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindParam(':id', $eventId);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':time', $time);
        $stmt->bindParam(':description', $description);
        return $stmt->execute();
    }

    // Delete an event
    public function deleteEvent($eventId) {
        $sql = "DELETE FROM events WHERE id = :id";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindParam(':id', $eventId);
        return $stmt->execute();
    }
}
?>
