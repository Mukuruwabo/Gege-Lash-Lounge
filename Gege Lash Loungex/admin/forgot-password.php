<?php
session_start();
include '../includes/config.php';
include '../includes/db.php';

if (isset($_SESSION['admin_logged_in'])) {
    header("Location: dashboard.php");
    exit;
}

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    
    if (empty($email)) {
        $error = "Please enter your email address";
    } else {
        try {
            $stmt = $pdo->prepare("SELECT id FROM admin_users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();
            
            if ($user) {
                // Generate reset token (valid for 1 hour)
                $token = bin2hex(random_bytes(32));
                $expires = date('Y-m-d H:i:s', time() + 3600);
                
                $pdo->prepare("UPDATE admin_users SET reset_token = ?, reset_expires = ? WHERE id = ?")
                    ->execute([$token, $expires, $user['id']]);
                
                // In a real application, you would send an email here
                $resetLink = BASE_URL . "admin/reset-password.php?token=$token";
                $message = "Password reset link has been sent to your email (simulated).";
                
                // For testing purposes, display the link
                $message .= "<br><small>Test link: <a href='$resetLink'>$resetLink</a></small>";
            } else {
                $error = "No account found with that email address";
            }
        } catch (PDOException $e) {
            $error = "Database error: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password | Gege Lash Lounge</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Same styles as login.php */
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo">
            <i class="fas fa-eye"></i>
            <span>Gege Lash Lounge</span>
        </div>
        <h1>Reset Password</h1>
        
        <?php if (!empty($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <?php if (!empty($message)): ?>
            <div class="message" style="color: var(--success); margin-bottom: 1rem;"><?= $message ?></div>
        <?php endif; ?>
        
        <form action="forgot-password.php" method="POST">
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <button type="submit" class="btn-login">Send Reset Link</button>
            <a href="login.php" class="forgot-password">Back to Login</a>
        </form>
    </div>
</body>
</html>