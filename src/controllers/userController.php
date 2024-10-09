<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
require_once '../config/db.php'; // Include database connection
require_once '../utils/helpers.php'; // Include helper functions

class UserController {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // User Registration
    public function register($username, $email, $password, $confirmPassword) {
        try {
            // Check if passwords match
            if ($password !== $confirmPassword) {
                $_SESSION['registration_error'] = "Passwords do not match.";
                header('Location: ../../public/register.html');
                exit();
            }

            // Check if username or email already exists
            $sql = "SELECT * FROM users WHERE username = :username OR email = :email";
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                $_SESSION['registration_error'] = "Username or email already taken.";
                header('Location: ../../public/register.html');
                exit();
            }

            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // Insert new user into the database
            $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->execute();

            // Redirect to login page with success message
            $_SESSION['registration_success'] = "Registration successful. You can now log in.";
            header('Location: ../../public/login.html');
            exit();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    // User Login (Already implemented)
    public function login($username, $password) {
        try {
            $sql = "SELECT * FROM users WHERE username = :username";
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verify the password
            if ($user && password_verify($password, $user['password'])) {
                // Set session and redirect to dashboard
                $_SESSION['user'] = $user['username'];
                header('Location: ../../public/dashboard.html');
                exit();
            } else {
                // Invalid login, redirect back with an error message
                $_SESSION['login_error'] = "Invalid username or password.";
                header('Location: ../../public/login.html');
                exit();
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}

// Check if the request is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    $userController = new UserController();

    if ($action === 'register') {
        $username = sanitizeInput($_POST['username']);
        $email = sanitizeInput($_POST['email']);
        $password = sanitizeInput($_POST['password']);
        $confirmPassword = sanitizeInput($_POST['confirmPassword']);
        $userController->register($username, $email, $password, $confirmPassword);
    } elseif ($action === 'login') {
        $username = sanitizeInput($_POST['username']);
        $password = sanitizeInput($_POST['password']);
        $userController->login($username, $password);
    }
} else {
    // Return a 405 Method Not Allowed error if not POST
    http_response_code(405);
    echo "Method Not Allowed";
}
?>
