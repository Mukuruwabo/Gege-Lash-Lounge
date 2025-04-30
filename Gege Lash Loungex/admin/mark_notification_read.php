<?php
require_once 'auth-check.php';
require_once '../includes/config.php';
require_once '../includes/db.php';

$data = json_decode(file_get_contents('php://input'), true);
$notificationId = (int)$data['id'];

$stmt = $pdo->prepare("UPDATE notifications SET is_read = 1 WHERE id = ? AND admin_id = ?");
$stmt->execute([$notificationId, $_SESSION['admin_id']]);
?>