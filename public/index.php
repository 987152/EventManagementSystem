<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

// Welcome message or event summary can be pulled from database here

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Event Planning Management</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f6f9;
        }
        
        /* Navbar styling */
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

        .navbar .logout {
            background-color: #dc3545;
            padding: 10px 20px;
            border-radius: 5px;
        }

        .container {
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
        }

        .header h1 {
            font-size: 36px;
            color: #333;
        }

        .card-container {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }

        .card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 300px;
            margin: 20px;
            text-align: center;
        }

        .card h3 {
            margin-bottom: 20px;
            color: #333;
        }

        .card a {
            background-color: #2e3b55;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .card a:hover {
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
        <div>
            <a href="index.php">Dashboard</a>
            <a href="event_management.php">Manage Events</a>
            <a href="guest_management.php">Manage Guests</a>
            <a href="vendor_management.php">Manage Vendors</a>
            <a href="report.php">Generate Reports</a>
        </div>
        <a href="logout.php" class="logout">Logout</a>
    </nav>

    <!-- Main Content -->
    <div class="container">
        <div class="header">
            <h1>Welcome to Event Planning Dashboard</h1>
            <p>Manage all your events, vendors, and guests in one place.</p>
        </div>

        <div class="card-container">
            <div class="card">
                <h3>Manage Events</h3>
                <a href="event_management.php">View Events</a>
            </div>
            <div class="card">
                <h3>Manage Guests</h3>
                <a href="guest_management.php">View Guests</a>
            </div>
            <div class="card">
                <h3>Manage Vendors</h3>
                <a href="vendor_management.php">View Vendors</a>
            </div>
            <div class="card">
                <h3>Generate Reports</h3>
                <a href="report.php">Generate</a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2024 Event Planning Management System. All Rights Reserved.</p>
    </footer>

</body>
</html>
