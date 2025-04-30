<?php
session_start();

// Database configuration
define('DB_HOST', '127.0.0.1');
define('DB_PORT', '3306');
define('DB_NAME', 'gege_lash_lounge');
define('DB_USER', 'root');
define('DB_PASS', '');

// Create database connection
try {
    $pdo = new PDO(
        "mysql:host=".DB_HOST.";port=".DB_PORT.";dbname=".DB_NAME,
        DB_USER,
        DB_PASS,
        array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        )
    );
    
    // SQL to create admin table if it doesn't exist
    $createTableSQL = "
    CREATE TABLE IF NOT EXISTS `admin_users` (
        `admin_id` INT AUTO_INCREMENT PRIMARY KEY,
        `username` VARCHAR(50) NOT NULL UNIQUE,
        `password` VARCHAR(255) NOT NULL,
        `email` VARCHAR(100),
        `full_name` VARCHAR(100),
        `last_login` DATETIME DEFAULT NULL,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        `status` ENUM('active','inactive') DEFAULT 'active',
        `role` VARCHAR(30) DEFAULT 'admin'
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    
    INSERT IGNORE INTO `admin_users` 
    (`username`, `password`, `email`, `full_name`, `role`) 
    VALUES 
    ('admin', '".password_hash('Admin@123', PASSWORD_BCRYPT)."', 'admin@gegelash.com', 'Administrator', 'superadmin'),
    ('manager', '".password_hash('Manager@123', PASSWORD_BCRYPT)."', 'manager@gegelash.com', 'Manager User', 'manager');
    ";
    
    $pdo->exec($createTableSQL);
    
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Redirect if already logged in
if (isset($_SESSION['admin_logged_in'])) {
    header("Location: dashboard.php");
    exit;
}

$error = '';
$loginAttempt = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $loginAttempt = true;
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';
    
    if (empty($username) || empty($password)) {
        $error = "Please enter both username and password";
    } else {
        try {
            $stmt = $pdo->prepare("
                SELECT `admin_id`, `username`, `password`, `full_name`, `role` 
                FROM `admin_users` 
                WHERE `username` = ? AND `status` = 'active' 
                LIMIT 1
            ");
            $stmt->execute(array($username));
            $user = $stmt->fetch();
            
            if ($user) {
                if (password_verify($password, $user['password'])) {
                    // Password is correct, create session
                    session_regenerate_id(true);
                    $_SESSION['admin_logged_in'] = true;
                    $_SESSION['admin_id'] = $user['admin_id'];
                    $_SESSION['admin_username'] = $user['username'];
                    $_SESSION['admin_name'] = $user['full_name'];
                    $_SESSION['admin_role'] = $user['role'];
                    
                    // Update last login time
                    $update = $pdo->prepare("
                        UPDATE `admin_users` 
                        SET `last_login` = NOW() 
                        WHERE `admin_id` = ?
                    ");
                    $update->execute(array($user['admin_id']));
                    
                    header("Location: dashboard.php");
                    exit;
                } else {
                    $error = "Invalid password. Please try again.";
                }
            } else {
                $error = "Username not found or account inactive";
            }
        } catch (PDOException $e) {
            error_log("Login Error: " . $e->getMessage());
            $error = "A system error occurred. Please try again later.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Gege Lash Lounge</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary:rgba(0, 0, 0, 0.9);
            --primary-dark:rgba(5, 5, 5, 0.8);
            --secondary: #f59e0b;
            --dark: #1e293b;
            --light: #f8fafc;
            --danger: #ef4444;
            --success: #10b981;
            --gray: #94a3b8;
            --gray-light: #e2e8f0;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f1f5f9;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-image: 
                radial-gradient(at 80% 0%, hsla(189, 100%, 56%, 0.1) 0px, 
                transparent 50%),
                radial-gradient(at 0% 50%, hsla(355, 100%, 93%, 0.1) 0px, 
                transparent 50%);
            animation: gradient 15s ease infinite;
            background-size: 200% 200%;
        }
        
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .login-container {
            background-color: white;
            border-radius: 16px;
            box-shadow: 
                0 10px 15px -3px rgba(0, 0, 0, 0.1),
                0 4px 6px -2px rgba(0, 0, 0, 0.05);
            width: 100%;
            max-width: 420px;
            padding: 2.5rem;
            text-align: center;
            transition: all 0.3s ease;
            transform: translateY(0);
            opacity: 1;
        }
        
        .login-container.loading {
            opacity: 0.8;
            transform: translateY(-10px);
        }
        
        .logo {
            margin-bottom: 2rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
        }
        
        .logo-icon {
            width: 60px;
            height: 60px;
            background-color: var(--primary);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            box-shadow: 0 4px 6px -1px rgba(99, 102, 241, 0.3);
            transition: all 0.3s ease;
        }
        
        .logo:hover .logo-icon {
            transform: rotate(15deg) scale(1.1);
            box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.3);
        }
        
        .logo-text {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--dark);
            letter-spacing: -0.5px;
        }
        
        h1 {
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            color: var(--dark);
            font-weight: 600;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
            text-align: left;
            position: relative;
        }
        
        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--dark);
            font-size: 0.95rem;
        }
        
        input {
            width: 100%;
            padding: 0.85rem 1rem;
            border: 1px solid var(--gray-light);
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: #f8fafc;
        }
        
        input:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
            background-color: white;
        }
        
        .input-icon {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray);
        }
        
        .btn-login {
            width: 100%;
            padding: 1rem;
            background-color: var(--primary);
            color: white;
            border: none;
            border-radius: 8px;
            font-family: 'Poppins', sans-serif;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        
        .btn-login:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.3);
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .error {
            color: var(--danger);
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            padding: 0.75rem 1rem;
            background-color: rgba(239, 68, 68, 0.1);
            border-radius: 8px;
            border-left: 4px solid var(--danger);
            animation: shake 0.5s ease;
            display: <?php echo $error ? 'block' : 'none'; ?>;
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20%, 60% { transform: translateX(-5px); }
            40%, 80% { transform: translateX(5px); }
        }
        
        .forgot-password {
            display: block;
            margin-top: 1.5rem;
            color: var(--primary);
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.2s ease;
            text-align: center;
        }
        
        .forgot-password:hover {
            text-decoration: underline;
            color: var(--primary-dark);
        }
        
        .default-creds {
            margin-top: 2rem;
            font-size: 0.85rem;
            color: var(--gray);
            background: #f8fafc;
            padding: 1rem;
            border-radius: 8px;
            border: 1px dashed var(--gray-light);
        }
        
        .default-creds strong {
            color: var(--dark);
            display: block;
            margin-bottom: 0.5rem;
        }
        
        .pulse {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(99, 102, 241, 0.4); }
            70% { box-shadow: 0 0 0 10px rgba(99, 102, 241, 0); }
            100% { box-shadow: 0 0 0 0 rgba(99, 102, 241, 0); }
        }
        
        .loading-spinner {
            display: none;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        .login-container.loading .loading-spinner {
            display: inline-block;
        }
        
        .login-container.loading .btn-text {
            display: none;
        }
    </style>
</head>
<body>
    <div class="login-container <?php echo $loginAttempt ? 'loading' : ''; ?>">
        <div class="logo">
            <div class="logo-icon pulse">
                <i class="fas fa-lock"></i>
            </div>
            <div class="logo-text">Gege Lash Lounge</div>
        </div>
        <h1>Admin Portal</h1>
        
        <?php if (!empty($error)): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <form action="login.php" method="POST" autocomplete="off" id="loginForm">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required autofocus value="admin">
                <i class="fas fa-user input-icon"></i>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required value="Admin@123">
                <i class="fas fa-key input-icon"></i>
            </div>
            
            <button type="submit" class="btn-login">
                <span class="loading-spinner"></span>
                <span class="btn-text">Sign In</span>
            </button>
            
            <a href="forgot-password.php" class="forgot-password">
                Forgot your password?
            </a>
        </form>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function() {
            document.querySelector('.login-container').classList.add('loading');
        });
        
        // Add animation to inputs on focus
        const inputs = document.querySelectorAll('input');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentNode.querySelector('.input-icon').style.color = '#6366f1';
                this.parentNode.style.transform = 'translateY(-2px)';
            });
            
            input.addEventListener('blur', function() {
                this.parentNode.querySelector('.input-icon').style.color = '#94a3b8';
                this.parentNode.style.transform = 'translateY(0)';
            });
        });
    </script>
</body>
</html>