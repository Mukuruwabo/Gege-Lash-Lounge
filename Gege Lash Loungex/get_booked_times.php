<?php
include '../includes/config.php';
include '../includes/db.php';

header('Content-Type: application/json');

if (isset($_GET['date'])) {
    $date = $_GET['date'];
    
    try {
        $stmt = $pdo->prepare("SELECT TIME_FORMAT(booking_time, '%H:%i') as time, COUNT(*) as count 
                              FROM bookings 
                              WHERE booking_date = ? AND status IN ('confirmed', 'pending')
                              GROUP BY booking_time");
        $stmt->execute([$date]);
        $times = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode($times);
    } catch (PDOException $e) {
        error_log("Database Error: " . $e->getMessage());
        echo json_encode([]);
    }
} else {
    echo json_encode([]);
}
?>