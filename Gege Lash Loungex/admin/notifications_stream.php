<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('Connection: keep-alive');

include '../includes/config.php';
include '../includes/db.php';

session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    exit;
}

$lastId = isset($_SERVER['HTTP_LAST_EVENT_ID']) ? $_SERVER['HTTP_LAST_EVENT_ID'] : 0;

while (true) {
    $stmt = $pdo->prepare("
        SELECT COUNT(*) as new_count 
        FROM notifications 
        WHERE admin_id = ? AND id > ? AND is_read = 0
    ");
    $stmt->execute([$_SESSION['admin_id'], $lastId]);
    $result = $stmt->fetch();
    
    if ($result['new_count'] > 0) {
        echo "data: " . json_encode(['type' => 'new_notification']) . "\n\n";
        ob_flush();
        flush();
        
        // Update last event ID
        $stmt = $pdo->prepare("SELECT MAX(id) as max_id FROM notifications WHERE admin_id = ?");
        $stmt->execute([$_SESSION['admin_id']]);
        $lastId = $stmt->fetch()['max_id'];
    }
    
    sleep(5); // Check every 5 seconds
}
?>