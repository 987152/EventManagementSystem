<?php
include 'header.php'; // Include the common header
require_once '../models/Event.php'; // Load the Event model

// Ensure the user is logged in
if (!isset($_SESSION['user'])) {
    header('Location: login.html');
    exit();
}

// Fetch the events
$eventModel = new Event();
$events = $eventModel->getAllEvents();
?>

<div class="container py-5">
    <h2 class="text-center mb-4">Your Event Management Dashboard</h2>
    <div class="row text-center">
        <div class="col-md-4 mb-4">
            <a href="event_scheduling.html" class="text-decoration-none">
                <div class="card shadow-sm p-4">
                    <h3>Event Scheduling</h3>
                    <p>Plan and schedule your upcoming events.</p>
                </div>
            </a>
        </div>
        <div class="col-md-4 mb-4">
            <a href="guest_management.html" class="text-decoration-none">
                <div class="card shadow-sm p-4">
                    <h3>Guest Management</h3>
                    <p>Manage your guest lists and RSVPs.</p>
                </div>
            </a>
        </div>
        <div class="col-md-4 mb-4">
            <a href="vendor_management.html" class="text-decoration-none">
                <div class="card shadow-sm p-4">
                    <h3>Vendor Management</h3>
                    <p>Handle your vendors and service providers.</p>
                </div>
            </a>
        </div>
        <div class="col-md-4 mb-4">
            <a href="resource_management.html" class="text-decoration-none">
                <div class="card shadow-sm p-4">
                    <h3>Resource Management</h3>
                    <p>Allocate venues, equipment, and staff.</p>
                </div>
            </a>
        </div>
    </div>

    <hr>
    <h3 class="text-center mb-4">Upcoming Events</h3>
    <?php if (count($events) > 0): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Event Name</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($events as $event): ?>
                    <tr>
                        <td><?= $event['name'] ?></td>
                        <td><?= $event['date'] ?></td>
                        <td><?= $event['time'] ?></td>
                        <td><?= $event['description'] ?></td>
                        <td>
                            <a href="edit_event.php?id=<?= $event['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="../controllers/eventController.php?action=deleteEvent&id=<?= $event['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-center">No upcoming events scheduled yet.</p>
    <?php endif; ?>
</div>

<?php
include 'footer.php'; // Include the common footer
?>
