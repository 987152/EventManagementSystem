<?php
session_start();
require_once '../src/controllers/EventController.php';

// Ensure the user is logged in
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

$eventController = new EventController();
$events = $eventController->listEvents();

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] == 'addEvent') {
            $eventController->addEvent($_POST['name'], $_POST['date'], $_POST['time'], $_POST['description']);
            header('Location: event_management.php');
        } elseif ($_POST['action'] == 'editEvent') {
            $eventController->editEvent($_POST['id'], $_POST['name'], $_POST['date'], $_POST['time'], $_POST['description']);
            header('Location: event_management.php');
        } elseif ($_POST['action'] == 'deleteEvent') {
            $eventController->deleteEvent($_POST['id']);
            header('Location: event_management.php');
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Events - Event Planning Management System</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body, html {
            height: 100%;
            font-family: 'Roboto', sans-serif;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            background-color: #2e3b55;
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            padding: 0 15px;
            font-size: 18px;
        }

        .container {
            flex: 1;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: center;
        }

        .form-container {
            margin: 20px 0;
        }

        .form-container form {
            display: flex;
            flex-direction: column;
            width: 300px;
            margin: 0 auto;
        }

        .form-container form input, .form-container form textarea, .form-container form button {
            margin: 10px 0;
            padding: 10px;
        }

        .btn {
            padding: 10px 15px;
            background-color: #2e3b55;
            color: white;
            border: none;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #ffc107;
        }

        .footer {
            background-color: #2e3b55;
            padding: 10px;
            color: white;
            text-align: center;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar">
        <a href="index.php">Dashboard</a>
        <a href="event_management.php">Manage Events</a>
        <a href="guest_management.php">Manage Guests</a>
        <a href="vendor_management.php">Manage Vendors</a>
        <a href="report.php">Generate Reports</a>
        <a href="logout.php" class="logout">Logout</a>
    </nav>

    <div class="container">
        <h1>Manage Events</h1>

        <!-- Display list of events -->
        <table>
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
                            <form action="event_management.php" method="POST" style="display:inline;">
                                <input type="hidden" name="action" value="deleteEvent">
                                <input type="hidden" name="id" value="<?= $event['id'] ?>">
                                <button class="btn" type="submit">Delete</button>
                            </form>
                            <button class="btn" onclick="editEvent(<?= $event['id'] ?>, '<?= $event['name'] ?>', '<?= $event['date'] ?>', '<?= $event['time'] ?>', '<?= $event['description'] ?>')">Edit</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Add Event Form -->
        <div class="form-container">
            <h3>Add Event</h3>
            <form action="event_management.php" method="POST">
                <input type="hidden" name="action" value="addEvent">
                <input type="text" name="name" placeholder="Event Name" required>
                <input type="date" name="date" required>
                <input type="time" name="time" required>
                <textarea name="description" placeholder="Event Description" rows="4" required></textarea>
                <button type="submit" class="btn">Add Event</button>
            </form>
        </div>

        <!-- Edit Event Form (JavaScript will populate form) -->
        <div class="form-container" id="editForm" style="display:none;">
            <h3>Edit Event</h3>
            <form action="event_management.php" method="POST">
                <input type="hidden" name="action" value="editEvent">
                <input type="hidden" name="id" id="editEventId">
                <input type="text" name="name" id="editEventName" placeholder="Event Name" required>
                <input type="date" name="date" id="editEventDate" required>
                <input type="time" name="time" id="editEventTime" required>
                <textarea name="description" id="editEventDescription" placeholder="Event Description" rows="4" required></textarea>
                <button type="submit" class="btn">Save Changes</button>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2024 Event Planning Management System. All Rights Reserved.</p>
    </footer>

    <!-- Inline JavaScript -->
    <script>
        function editEvent(id, name, date, time, description) {
            document.getElementById('editForm').style.display = 'block';
            document.getElementById('editEventId').value = id;
            document.getElementById('editEventName').value = name;
            document.getElementById('editEventDate').value = date;
            document.getElementById('editEventTime').value = time;
            document.getElementById('editEventDescription').value = description;
        }
    </script>
</body>
</html>
