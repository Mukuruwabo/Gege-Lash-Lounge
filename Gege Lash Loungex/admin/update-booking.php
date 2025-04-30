<?php
require_once 'auth-check.php';
require_once '../includes/config.php';
require_once '../includes/db.php';

header('Content-Type: application/json');

// Validate input
if (!isset($_POST['id'])) {  // Added missing closing parenthesis here
    echo json_encode(['success' => false, 'message' => 'Booking ID is required']);
    exit;
}

if (!isset($_POST['status'])) {
    echo json_encode(['success' => false, 'message' => 'Status is required']);
    exit;
}

$bookingId = (int)$_POST['id'];
$status = in_array($_POST['status'], ['confirmed', 'cancelled', 'pending']) ? $_POST['status'] : null;

if ($bookingId <= 0 || !$status) {
    echo json_encode(['success' => false, 'message' => 'Invalid input data']);
    exit;
}

try {
    // Start transaction
    $pdo->beginTransaction();

    // Update booking status
    $stmt = $pdo->prepare("UPDATE bookings SET status = ? WHERE id = ?");
    $stmt->execute([$status, $bookingId]);

    // Check if any row was affected
    if ($stmt->rowCount() === 0) {
        $pdo->rollBack();
        echo json_encode(['success' => false, 'message' => 'No booking found with that ID']);
        exit;
    }

    // Get booking details for notification
    $stmt = $pdo->prepare("SELECT b.client_id, c.username, s.name, b.booking_date, b.booking_time 
                          FROM bookings b 
                          JOIN clients c ON b.client_id = c.id 
                          JOIN services s ON b.service_id = s.id 
                          WHERE b.id = ?");
    $stmt->execute([$bookingId]);
    $booking = $stmt->fetch();

    if ($booking) {
        // Create notification
        $message = sprintf(
            "Booking for %s (%s on %s at %s) was %s",
            $booking['username'],
            $booking['name'],
            date('M j, Y', strtotime($booking['booking_date'])),
            date('g:i A', strtotime($booking['booking_time'])),
            $status
        );
        
        $stmt = $pdo->prepare("INSERT INTO notifications (admin_id, booking_id, message, type, created_at) 
                              VALUES (?, ?, ?, 'booking', NOW())");
        $stmt->execute([$_SESSION['admin_id'], $bookingId, $message]);
    }

    $pdo->commit();
    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    $pdo->rollBack();
    error_log("Update Booking Error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
} catch (Exception $e) {
    $pdo->rollBack();
    error_log("Update Booking Error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}