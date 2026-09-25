<?php
/**
 * Logout Action
 * Safely terminates administrator sessions and cookie stores.
 */
require_once 'config.php';

// Clear session variables
$_SESSION = [];

// Destroy session cookies if active
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Terminate PHP session
session_destroy();

// Start fresh session to pass log-out message
session_start();
$_SESSION['flash_success'] = "You have been logged out securely.";

// Redirect to authentication login page
header("Location: login.php");
exit;
