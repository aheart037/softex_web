<?php
/**
 * Configuration file for Softex Invoice Management System
 * Establishes PDO database connection, manages sessions, and provides helper functions.
 */

// Prevent direct access to config file
if (basename($_SERVER['PHP_SELF']) == 'config.php') {
    die('Direct access not permitted.');
}

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Set timezone
date_default_timezone_set('Asia/Karachi');

// Database configuration
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'sophiyaw_inv');
define('DB_PASS', 'Sameer@123');
define('DB_NAME', 'sophiyaw_inv_sys');

try {
    // Establish secure PDO connection
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
} catch (PDOException $e) {
    // Handle connection error gracefully
    die("Database Connection Failed: " . $e->getMessage());
}

// Load all settings from settings table into a static cache
$settings_cache = [];
try {
    $stmt = $pdo->query("SELECT setting_key, setting_value FROM settings");
    while ($row = $stmt->fetch()) {
        $settings_cache[$row['setting_key']] = $row['setting_value'];
    }
} catch (PDOException $e) {
    // Settings table might not exist yet during setup
}

/**
 * Get setting value by key with optional default fallback
 */
function get_setting($key, $default = '') {
    global $settings_cache;
    return isset($settings_cache[$key]) ? $settings_cache[$key] : $default;
}

/**
 * Helper to update a setting in database and cache
 */
function update_setting($key, $value) {
    global $pdo, $settings_cache;
    $stmt = $pdo->prepare("INSERT INTO settings (setting_key, setting_value) VALUES (?, ?) 
                           ON DUPLICATE KEY UPDATE setting_value = ?");
    $stmt->execute([$key, $value, $value]);
    $settings_cache[$key] = $value;
}

/**
 * Check if admin is logged in, return boolean
 */
function is_logged_in() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

/**
 * Require login to access page - redirects unauthorized users to login page
 */
function require_login() {
    if (!is_logged_in()) {
        // Clear session and redirect
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
        
        // Start fresh session to pass flash message
        session_start();
        $_SESSION['flash_error'] = "Please log in to access the system.";
        header("Location: login.php");
        exit;
    }
}

/**
 * Sanitize output to protect against XSS
 */
function h($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

/**
 * Format currency nicely for display (Pakistani Rupee Rs. or standard currency representation)
 */
function format_currency($amount) {
    return "Rs. " . number_of_format((float)$amount);
}

function number_of_format($amount) {
    return number_format($amount, 2, '.', ',');
}

/**
 * Generate a flash message (alert-success, alert-danger)
 */
function display_flash_message() {
    $html = '';
    if (isset($_SESSION['flash_success'])) {
        $html .= '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>' . h($_SESSION['flash_success']) . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
        unset($_SESSION['flash_success']);
    }
    if (isset($_SESSION['flash_error'])) {
        $html .= '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>' . h($_SESSION['flash_error']) . '
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
        unset($_SESSION['flash_error']);
    }
    return $html;
}

/**
 * Generate Next Auto Invoice Number (INV-XXXX)
 */
function generate_next_invoice_number() {
    global $pdo;
    $stmt = $pdo->query("SELECT MAX(id) AS max_id FROM invoices");
    $row = $stmt->fetch();
    $next_id = ($row && $row['max_id']) ? $row['max_id'] + 1 : 1;
    return 'INV-' . str_pad($next_id, 4, '0', STR_PAD_LEFT);
}
