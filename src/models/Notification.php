<?php
require_once '../config/db.php';

class Notification {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Get notifications for a specific user
    public function getNotificationsForUser($username) {
        $sql = "SELECT * FROM notifications WHERE username = :username ORDER BY created_at DESC";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Add a new notification
    public function addNotification($username, $message) {
        $sql = "INSERT INTO notifications (username, message) VALUES (:username, :message)";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':message', $message);
        return $stmt->execute();
    }

    // Delete a notification by ID
    public function deleteNotification($id) {
        $sql = "DELETE FROM notifications WHERE id = :id";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>
