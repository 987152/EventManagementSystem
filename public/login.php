<?php
session_start();
require_once '../src/config/db.php';
require_once '../src/controllers/UserController.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userController = new UserController();
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($userController->login($username, $password)) {
        $_SESSION['user'] = $username;
        header('Location: index.php');
    } else {
        $message = "Invalid login credentials!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Event Planning System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Roboto', sans-serif; background-color: #f4f6f9; }
        .container { max-width: 400px; margin-top: 100px; }
        .btn-primary { background-color: #2e3b55; border: none; }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Event Planning Login</h2>
        <?php if ($message): ?>
            <div class="alert alert-danger"><?= $message ?></div>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
        <p class="text-center mt-3">Don't have an account? <a href="register.php">Register here</a></p>
    </div>
</body>
</html>
