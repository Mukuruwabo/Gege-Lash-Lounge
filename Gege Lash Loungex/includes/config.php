<?php
// Start session only if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if constants are not already defined
if (!defined('BASE_URL')) {
    define('BASE_URL', 'http://localhost/Gege-Lash-Loungex/');
}

if (!defined('BUSINESS_PHONE')) {
    define('BUSINESS_PHONE', '+250788822851');
}

if (!defined('BUSINESS_EMAIL')) {
    define('BUSINESS_EMAIL', 'info@gegelash.com');
}

if (!defined('BUSINESS_LOCATION')) {
    define('BUSINESS_LOCATION', 'Kigali, Rwanda');
}
    
// Security headers
header("X-Frame-Options: DENY");
header("X-Content-Type-Options: nosniff");
header("X-XSS-Protection: 1; mode=block");
header("Referrer-Policy: strict-origin-when-cross-origin");

// Session security settings
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1); // Enable this if using HTTPS
ini_set('session.use_strict_mode', 1);
ini_set('session.cookie_samesite', 'Strict');

// Check if functions are not already declared
if (!function_exists('generate_csrf_token')) {
    function generate_csrf_token() {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
}

if (!function_exists('verify_csrf_token')) {
    function verify_csrf_token($token) {
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }
}
// SMS Configuration
define('SMS_PROVIDER', 'africastalking'); // or 'mtn'
define('SMS_API_KEY', 'your_api_key_here');
define('SMS_USERNAME', 'your_username_here');
define('SMS_SENDER_ID', 'GegeLash'); // Must be approved by provider
define('SMS_ENABLED', true); // Set to false to disable SMS
?>