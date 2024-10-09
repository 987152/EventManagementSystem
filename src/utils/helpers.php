<?php

/**
 * Validate email format
 *
 * @param string $email
 * @return bool
 */
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Validate if a string contains only letters and spaces
 *
 * @param string $string
 * @return bool
 */
function validateString($string) {
    return preg_match("/^[a-zA-Z ]+$/", $string);
}

/**
 * Validate if a string contains a valid date (YYYY-MM-DD)
 *
 * @param string $date
 * @return bool
 */
function validateDate($date) {
    $d = DateTime::createFromFormat('Y-m-d', $date);
    return $d && $d->format('Y-m-d') === $date;
}

/**
 * Validate if a string contains a valid time (HH:MM format)
 *
 * @param string $time
 * @return bool
 */
function validateTime($time) {
    return preg_match("/^(2[0-3]|[01][0-9]):([0-5][0-9])$/", $time);
}



/**
 * Check if required form fields are filled
 *
 * @param array $requiredFields
 * @return bool
 */
function checkRequiredFields($requiredFields) {
    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            return false;
        }
    }
    return true;
}

// Sanitize input to prevent XSS attacks
function sanitizeInput($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

/**
 * Check if a password is strong enough
 * Conditions:
 * - Minimum 8 characters
 * - Contains at least one uppercase letter, one lowercase letter, one number, and one special character
 *
 * @param string $password
 * @return bool
 */
function validatePassword($password) {
    return preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\W).{8,}$/', $password);
}

/**
 * Generate a random token (for CSRF protection or password resets)
 *
 * @param int $length
 * @return string
 */
function generateToken($length = 32) {
    return bin2hex(random_bytes($length / 2));
}

/**
 * Redirect to another page
 *
 * @param string $url
 */
function redirect($url) {
    header("Location: $url");
    exit();
}

/**
 * Check if a user is logged in
 *
 * @return bool
 */
function isLoggedIn() {
    return isset($_SESSION['user']);
}

/**
 * Flash a message (to be displayed on the next page load)
 *
 * @param string $name
 * @param string $message
 * @param string $class
 */
function flashMessage($name = '', $message = '', $class = 'alert alert-success') {
    if (!empty($name)) {
        if (!empty($message) && empty($_SESSION[$name])) {
            if (!empty($_SESSION[$name])) {
                unset($_SESSION[$name]);
            }
            if (!empty($_SESSION[$name . '_class'])) {
                unset($_SESSION[$name . '_class']);
            }

            $_SESSION[$name] = $message;
            $_SESSION[$name . '_class'] = $class;
        } elseif (empty($message) && !empty($_SESSION[$name])) {
            $class = !empty($_SESSION[$name . '_class']) ? $_SESSION[$name . '_class'] : '';
            echo '<div class="' . $class . '" id="msg-flash">' . $_SESSION[$name] . '</div>';
            unset($_SESSION[$name]);
            unset($_SESSION[$name . '_class']);
        }
    }
}

?>
