<?php
session_start();
include '../includes/config.php';
include '../includes/db.php';

if (!isset($_SESSION['admin_logged_in'])) {
    http_response_code(401);
    exit;
}

$notifications = $pdo->query("
    SELECT n.*, c.username as client_name, s.name as service_name
    FROM notifications n
    LEFT JOIN bookings b ON n.booking_id = b.id
    LEFT JOIN clients c ON b.client_id = c.id
    LEFT JOIN services s ON b.service_id = s.id
    WHERE n.admin_id = {$_SESSION['admin_id']}
    ORDER BY n.is_read ASC, n.created_at DESC
    LIMIT 10
")->fetchAll(PDO::FETCH_ASSOC);

$unreadCount = $pdo->query("
    SELECT COUNT(*) 
    FROM notifications 
    WHERE admin_id = {$_SESSION['admin_id']} AND is_read = 0
")->fetchColumn();

header('Content-Type: application/json');
echo json_encode([
    'notifications' => $notifications,
    'unreadCount' => $unreadCount
]);
?>