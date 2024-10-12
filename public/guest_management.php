<?php
session_start();
require_once '../src/controllers/GuestController.php';
require_once '../src/controllers/EventController.php'; // Include EventController to fetch events

// Ensure the user is logged in
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

$guestController = new GuestController();
$eventController = new EventController();
$guests = $guestController->listGuests();
$events = $eventController->listEvents(); // Fetch events for dropdown

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] == 'addGuest') {
            $guestController->addGuest($_POST['name'], $_POST['email'], $_POST['rsvp_status'], $_POST['event_id']);
            header('Location: guest_management.php');
        } elseif ($_POST['action'] == 'editGuest') {
            $guestController->editGuest($_POST['id'], $_POST['name'], $_POST['email'], $_POST['rsvp_status'], $_POST['event_id']);
            header('Location: guest_management.php');
        } elseif ($_POST['action'] == 'deleteGuest') {
            $guestController->deleteGuest($_POST['id']);
            header('Location: guest_management.php');
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Guests - Event Planning Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
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

        .form-container form input, .form-container form select, .form-container form textarea, .form-container form button {
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
            margin-top: 50px;
            position: absolute;
            width: 100%;
            bottom: 0;
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
        <h1>Manage Guests</h1>

        <!-- Button to open the Add Guest modal -->
        <button class="btn" data-bs-toggle="modal" data-bs-target="#addGuestModal">Add New Guest</button>

        <!-- Display list of guests -->
        <table>
            <thead>
                <tr>
                    <th>Guest Name</th>
                    <th>Email</th>
                    <th>RSVP Status</th>
                    <th>Event</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($guests as $guest): ?>
                    <tr>
                        <td><?= $guest['name'] ?></td>
                        <td><?= $guest['email'] ?></td>
                        <td><?= $guest['rsvp_status'] ?></td>
                        <td><?= $guest['event_name'] ?></td>
                        <td>
                            <form action="guest_management.php" method="POST" style="display:inline;">
                                <input type="hidden" name="action" value="deleteGuest">
                                <input type="hidden" name="id" value="<?= $guest['id'] ?>">
                                <button class="btn" type="submit">Delete</button>
                            </form>
                            <button class="btn" data-bs-toggle="modal" data-bs-target="#editGuestModal" onclick="editGuest(<?= $guest['id'] ?>, '<?= $guest['name'] ?>', '<?= $guest['email'] ?>', '<?= $guest['rsvp_status'] ?>', '<?= $guest['event_id'] ?>')">Edit</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Add Guest Modal -->
        <div class="modal fade" id="addGuestModal" tabindex="-1" aria-labelledby="addGuestModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addGuestModalLabel">Add Guest</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="guest_management.php" method="POST">
                        <div class="modal-body">
                            <input type="hidden" name="action" value="addGuest">
                            <input type="text" name="name" placeholder="Guest Name" required class="form-control">
                            <input type="email" name="email" placeholder="Email" required class="form-control">
                            <select name="rsvp_status" required class="form-control">
                                <option value="accepted">Accepted</option>
                                <option value="declined">Declined</option>
                                <option value="invited">Invited</option>
                            </select>
                            <select name="event_id" required class="form-control">
                                <option value="">Select Event</option>
                                <?php foreach ($events as $event): ?>
                                    <option value="<?= $event['id'] ?>"><?= $event['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add Guest</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Guest Modal -->
        <div class="modal fade" id="editGuestModal" tabindex="-1" aria-labelledby="editGuestModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editGuestModalLabel">Edit Guest</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="guest_management.php" method="POST">
                        <div class="modal-body">
                            <input type="hidden" name="action" value="editGuest">
                            <input type="hidden" name="id" id="editGuestId">
                            <input type="text" name="name" id="editGuestName" placeholder="Guest Name" required class="form-control">
                            <input type="email" name="email" id="editGuestEmail" placeholder="Email" required class="form-control">
                            <select name="rsvp_status" id="editGuestRSVP" required class="form-control">
                                <option value="accepted">Accepted</option>
                                <option value="declined">Declined</option>
                                <option value="invited">Invited</option>
                            </select>
                            <select name="event_id" id="editGuestEvent" required class="form-control">
                                <?php foreach ($events as $event): ?>
                                    <option value="<?= $event['id'] ?>"><?= $event['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2024 Event Planning Management System. All Rights Reserved.</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JavaScript to handle edit action -->
    <script>
        function editGuest(id, name, email, rsvp_status, event_id) {
            document.getElementById('editGuestId').value = id;
            document.getElementById('editGuestName').value = name;
            document.getElementById('editGuestEmail').value = email;
            document.getElementById('editGuestRSVP').value = rsvp_status;
            document.getElementById('editGuestEvent').value = event_id;
        }
    </script>
</body>
</html>
