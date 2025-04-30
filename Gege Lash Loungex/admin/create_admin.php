<?php
require_once '../includes/config.php';
require_once '../includes/db.php';

$username = 'admin';
$plain_password = 'admin123'; // Change this to your desired password
$email = 'admin@gegelash.com';

// Generate secure password hash
$hashed_password = password_hash($plain_password, PASSWORD_BCRYPT);

try {
    $stmt = $pdo->prepare("
        INSERT INTO admin_users (username, password, email, is_active) 
        VALUES (:username, :password, :email, 1)
    ");
    
    $stmt->execute([
        ':username' => $username,
        ':password' => $hashed_password,
        ':email' => $email
    ]);
    
    echo "Admin user created successfully!<br>";
    echo "Username: $username<br>";
    echo "Password: $plain_password<br>";
    echo "Hashed password: $hashed_password";
} catch (PDOException $e) {
    echo "Error creating admin user: " . $e->getMessage();
    
    // Check if user already exists
    $stmt = $pdo->prepare("SELECT * FROM admin_users WHERE username = :username");
    $stmt->execute([':username' => $username]);
    $user = $stmt->fetch();
    
    if ($user) {
        echo "<br>User already exists. Current hash: " . $user['password'];
    }
}
?>