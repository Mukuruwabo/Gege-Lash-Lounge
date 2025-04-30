<?php
include 'includes/config.php';
include 'includes/db.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Validate all required fields exist
        $required = ['username', 'email', 'phone', 'service', 'date', 'time'];
        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                throw new Exception("Please fill in all required fields");
            }
        }

        // Sanitize and validate inputs
        $username = htmlspecialchars(trim($_POST['username']));
        $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
        $phone = preg_replace('/[^0-9]/', '', $_POST['phone']);
        $service_id = (int)$_POST['service'];
        $date = date('Y-m-d', strtotime($_POST['date']));
        $time = date('H:i:s', strtotime($_POST['time']));
        $request = isset($_POST['request']) ? htmlspecialchars(trim($_POST['request'])) : '';

        if (!$email) {
            throw new Exception("Please enter a valid email address");
        }

        if (strlen($phone) < 10) {
            throw new Exception("Please enter a valid phone number (at least 10 digits)");
        }

        // Check time slot availability (only count active bookings)
        $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM bookings 
                             WHERE booking_date = ? AND booking_time = ? 
                             AND status IN ('confirmed', 'pending')");
        $stmt->execute([$date, $time]);
        $result = $stmt->fetch();

        if ($result['count'] >= 2) {
            header("Location: ".BASE_URL."/index.php?error=time_slot_full");
            exit;
        }

        // Check if client exists (using both email AND phone for exact match)
        $stmt = $pdo->prepare("SELECT id FROM clients WHERE email = ? AND phone = ?");
        $stmt->execute([$email, $phone]);
        $client = $stmt->fetch();

        $pdo->beginTransaction();

        if (!$client) {
            // Create new client
            $stmt = $pdo->prepare("INSERT INTO clients (username, email, phone, created_at) 
                                  VALUES (?, ?, ?, NOW())");
            $stmt->execute([$username, $email, $phone]);
            $client_id = $pdo->lastInsertId();
        } else {
            $client_id = $client['id'];
            // Update client name if changed
            $stmt = $pdo->prepare("UPDATE clients SET username = ? WHERE id = ?");
            $stmt->execute([$username, $client_id]);
        }

        // Create booking with PENDING status
        $stmt = $pdo->prepare("INSERT INTO bookings 
                             (client_id, service_id, booking_date, booking_time, 
                             special_request, status, created_at) 
                             VALUES (?, ?, ?, ?, ?, 'pending', NOW())");
        $stmt->execute([$client_id, $service_id, $date, $time, $request]);
        $booking_id = $pdo->lastInsertId();

        // Create admin notification
        $message = "New booking request from $username";
        $stmt = $pdo->prepare("INSERT INTO notifications 
                             (admin_id, booking_id, message, is_read, created_at) 
                             VALUES (1, ?, ?, 0, NOW())");
        $stmt->execute([$booking_id, $message]);

        // Send confirmation email to client
        sendConfirmationEmail($email, $username, $service_id, $date, $time);

        $pdo->commit();

        // Redirect to success page
        header("Location: ".BASE_URL."/index.php?booking=success&date=$date&time=$time&service=$service_id");
        exit;

    } catch (PDOException $e) {
        if (isset($pdo) && $pdo->inTransaction()) {
            $pdo->rollBack();
        }
        error_log("Database Error: " . $e->getMessage());
        header("Location: ".BASE_URL."/index.php?error=db_error");
        exit;
    } catch (Exception $e) {
        if (isset($pdo) && $pdo->inTransaction()) {
            $pdo->rollBack();
        }
        error_log("Booking Error: " . $e->getMessage());
        $errorMessage = urlencode($e->getMessage());
        header("Location: ".BASE_URL."/index.php?error=booking_failed&message=$errorMessage");
        exit;
    }
} else {
    header("Location: ".BASE_URL);
    exit;
}

function sendConfirmationEmail($to, $name, $service_id, $date, $time) {
    $subject = "Your Booking Confirmation - Gege Lash Lounge";
    
    $service_name = [
        1 => "Classic Lashes (25,000 RWF)",
        2 => "Hybrid Lashes (30,000 RWF)",
        3 => "Volume Lashes (35,000 RWF)",
        4 => "Mega Volume Lashes (40,000 RWF)"
    ][$service_id];
    
    $formatted_date = date('l, F j, Y', strtotime($date));
    $formatted_time = date('g:i A', strtotime($time));
    
    $message = "
    <html>
    <head>
        <title>Your Booking Confirmation</title>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background-color: #D4AF37; color: white; padding: 20px; text-align: center; }
            .content { padding: 20px; background-color: #f9f9f9; }
            .footer { padding: 20px; text-align: center; font-size: 12px; color: #777; }
            .booking-details { background-color: white; padding: 20px; margin: 20px 0; border-radius: 5px; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h1>Gege Lash Lounge</h1>
                <p>Your Booking Confirmation</p>
            </div>
            
            <div class='content'>
                <p>Dear $name,</p>
                <p>Thank you for booking with Gege Lash Lounge! Here are your appointment details:</p>
                
                <div class='booking-details'>
                    <h3>Appointment Summary</h3>
                    <p><strong>Service:</strong> $service_name</p>
                    <p><strong>Date:</strong> $formatted_date</p>
                    <p><strong>Time:</strong> $formatted_time</p>
                </div>
                
                <p>We look forward to seeing you at our studio in Remera, Kisimenti. Please arrive 5 minutes before your scheduled time.</p>
                <p>If you need to reschedule or cancel your appointment, please contact us at least 24 hours in advance.</p>
                
                <p>Best regards,<br>The Gege Lash Lounge Team</p>
            </div>
            
            <div class='footer'>
                <p>© ".date('Y')." Gege Lash Lounge. All rights reserved.</p>
                <p>Remera, Kisimenti, Kigali | ".BUSINESS_PHONE." | ".BUSINESS_EMAIL."</p>
            </div>
        </div>
    </body>
    </html>
    ";
    
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: Gege Lash Lounge <".BUSINESS_EMAIL.">" . "\r\n";
    
    // In production, you would use a proper mailer library
    @mail($to, $subject, $message, $headers);
}
// After successful booking ($pdo->commit();)
if (SMS_ENABLED) {
    try {
        $smsService = new SMSService();
        $smsMessage = "Hello $username, your $service_name appointment is pending confirmation for $formatted_date at $formatted_time. We'll notify you once confirmed.";
        $smsResponse = $smsService->sendSMS($phone, $smsMessage);
        
        // Log SMS response
        file_put_contents('../logs/sms.log', date('Y-m-d H:i:s') . " - New booking - $smsResponse\n", FILE_APPEND);
    } catch (Exception $e) {
        error_log("SMS sending failed: " . $e->getMessage());
    }
}
?>