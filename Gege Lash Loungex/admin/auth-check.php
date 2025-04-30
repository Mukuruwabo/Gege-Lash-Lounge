<?php
// Check if session needs to be started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Define the login page URL
$login_url = 'login.php';

// Check if user is logged in and has required session variables
if (!isset($_SESSION['admin_logged_in']) || 
    !$_SESSION['admin_logged_in'] || 
    !isset($_SESSION['admin_id'])) {
    
    // Clear any existing session data
    $_SESSION = array();
    
    // If the session is being killed, also delete the session cookie
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    
    // Finally, destroy the session
    session_destroy();
    
    // Redirect to login page
    header("Location: $login_url");
    exit;
}

// Optional: Verify admin_id exists in database
require_once '../includes/config.php';
require_once '../includes/db.php';

try {
    $stmt = $pdo->prepare("SELECT id FROM admin_users WHERE id = ?");
    $stmt->execute([$_SESSION['admin_id']]);
    $user = $stmt->fetch();
    
    if (!$user) {
        // User doesn't exist in database - force logout
        session_unset();
        session_destroy();
        header("Location: $login_url");
        exit;
    }
} catch (PDOException $e) {
    // Log error but allow access (you might want to handle this differently)
    error_log("Database error during auth check: " . $e->getMessage());
}
?>