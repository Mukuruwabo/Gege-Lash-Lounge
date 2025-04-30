<?php
session_start();
include '../includes/config.php';
include '../includes/db.php';

if (isset($_SESSION['admin_logged_in'])) {
    header("Location: dashboard.php");
    exit;
}

$token = $_GET['token'] ?? '';
$error = '';
$success = '';

if (empty($token)) {
    $error = "Invalid reset token";
} else {
    try {
        $stmt = $pdo->prepare("SELECT id FROM admin_users WHERE reset_token = ? AND reset_expires > NOW()");
        $stmt->execute([$token]);
        $user = $stmt->fetch();
        
        if (!$user) {
            $error = "Invalid or expired reset token";
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = trim($_POST['password']);
            $confirm_password = trim($_POST['confirm_password']);
            
            if (empty($password) || empty($confirm_password)) {
                $error = "Please enter and confirm your new password";
            } elseif ($password !== $confirm_password) {
                $error = "Passwords do not match";
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                
                $pdo->prepare("UPDATE admin_users SET password = ?, reset_token = NULL, reset_expires = NULL WHERE id = ?")
                    ->execute([$hashed_password, $user['id']]);
                
                $success = "Password reset successfully. You can now <a href='login.php'>login</a>.";
            }
        }
    } catch (PDOException $e) {
        $error = "Database error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | Gege Lash Lounge</title>
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
        <h1>Set New Password</h1>
        
        <?php if (!empty($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php elseif (!empty($success)): ?>
            <div class="message" style="color: var(--success); margin-bottom: 1rem;"><?= $success ?></div>
        <?php else: ?>
            <form action="reset-password.php?token=<?= htmlspecialchars($token) ?>" method="POST">
                <div class="form-group">
                    <label for="password">New Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <div class="form-group">
                    <label for="confirm_password">Confirm New Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>
                
                <button type="submit" class="btn-login">Reset Password</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>