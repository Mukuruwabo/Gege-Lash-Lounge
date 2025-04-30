<?php
session_start();
include '../includes/config.php';
include '../includes/db.php';

if (!isset($_SESSION['admin_logged_in'])) {
    http_response_code(401);
    exit;
}

$stmt = $pdo->prepare("UPDATE notifications SET is_read = 1 WHERE admin_id = ?");
$stmt->execute([$_SESSION['admin_id']]);
?>