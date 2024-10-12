<?php
require_once '../src/config/db.php';

class EventController {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // List all events
    public function listEvents() {
        $query = "SELECT * FROM events ORDER BY date ASC, time ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Add a new event
    public function addEvent($name, $date, $time, $description) {
        $query = "INSERT INTO events (name, date, time, description) VALUES (:name, :date, :time, :description)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':time', $time);
        $stmt->bindParam(':description', $description);

        return $stmt->execute();
    }

    // Edit an event
    public function editEvent($id, $name, $date, $time, $description) {
        $query = "UPDATE events SET name = :name, date = :date, time = :time, description = :description WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':time', $time);
        $stmt->bindParam(':description', $description);

        return $stmt->execute();
    }

    // Delete an event
    public function deleteEvent($id) {
        $query = "DELETE FROM events WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }
}
