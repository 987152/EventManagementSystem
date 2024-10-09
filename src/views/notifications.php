<?php
include 'header.php'; // Include the common header

// Assuming notifications are stored in the database in a 'notifications' table
require_once '../models/Notification.php'; // Load the Notification model

// Ensure the user is logged in
if (!isset($_SESSION['user'])) {
    header('Location: login.html');
    exit();
}

// Fetch user-specific notifications
$notificationModel = new Notification();
$notifications = $notificationModel->getNotificationsForUser($_SESSION['user']);
?>

<div class="container py-5">
    <h2 class="text-center mb-4">Your Notifications</h2>

    <?php if (count($notifications) > 0): ?>
        <ul class="list-group">
            <?php foreach ($notifications as $notification): ?>
                <li class="list-group-item">
                    <?= $notification['message'] ?>
                    <span class="float-end"><?= $notification['created_at'] ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p class="text-center">You have no notifications.</p>
    <?php endif; ?>
</div>

<?php
include 'footer.php'; // Include the common footer
?>

