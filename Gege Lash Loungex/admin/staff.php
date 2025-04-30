<?php
session_start();
include '../includes/config.php';
include '../includes/db.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: index.php");
    exit;
}

try {
    // Get all staff members
    $stmt = $pdo->query("SELECT * FROM staff ORDER BY name ASC");
    $staff = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff - Gege Lash Lounge</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #a8a632;
            --dark: #121212;
            --light: #ffffff;
            --gray: #f5f5f5;
            --success: #28a745;
            --danger: #dc3545;
            --info: #17a2b8;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background-color: var(--gray);
            color: var(--dark);
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar */
        .sidebar {
            width: 250px;
            background-color: var(--dark);
            color: var(--light);
            height: 100vh;
            position: fixed;
            padding: 20px 0;
        }
        
        .sidebar-header {
            padding: 0 20px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .sidebar-header h3 {
            color: var(--primary);
            font-size: 1.5rem;
        }
        
        .sidebar-menu {
            padding: 20px 0;
        }
        
        .sidebar-menu ul {
            list-style: none;
        }
        
        .sidebar-menu li a {
            display: block;
            padding: 12px 20px;
            color: var(--light);
            text-decoration: none;
        }
        
        .sidebar-menu li a:hover,
        .sidebar-menu li a.active {
            background-color: rgba(168, 166, 50, 0.2);
            color: var(--primary);
        }
        
        .sidebar-menu li a i {
            margin-right: 10px;
        }
        
        /* Content */
        .content {
            flex: 1;
            margin-left: 250px;
            padding: 30px;
        }
        
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .page-title {
            font-size: 1.8rem;
        }
        
        /* Staff Cards */
        .staff-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }
        
        .staff-card {
            background-color: var(--light);
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
        }
        
        .staff-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            margin-right: 15px;
            flex-shrink: 0;
        }
        
        .staff-details {
            flex: 1;
        }
        
        .staff-name {
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .staff-position {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 5px;
        }
        
        .staff-contact {
            font-size: 0.85rem;
            color: #777;
            margin-bottom: 5px;
        }
        
        .staff-status {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .staff-status.active {
            background-color: rgba(40, 167, 69, 0.2);
            color: var(--success);
        }
        
        .staff-status.inactive {
            background-color: rgba(220, 53, 69, 0.2);
            color: var(--danger);
        }
        
        /* Buttons */
        .btn {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.8rem;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-sm {
            padding: 5px 10px;
            font-size: 0.7rem;
        }
        
        .btn-primary {
            background-color: var(--primary);
            color: white;
        }
        
        .btn-info {
            background-color: var(--info);
            color: white;
        }
        
        .btn-danger {
            background-color: var(--danger);
            color: white;
        }
        
        .action-buttons {
            display: flex;
            gap: 5px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h3>Gege Lash Lounge</h3>
        </div>
        <div class="sidebar-menu">
            <ul>
                <li><a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="bookings.php"><i class="fas fa-calendar-check"></i> Bookings</a></li>
                <li><a href="clients.php"><i class="fas fa-users"></i> Clients</a></li>
                <li><a href="staff.php" class="active"><i class="fas fa-user-tie"></i> Staff</a></li>
                <li><a href="reports.php"><i class="fas fa-chart-bar"></i> Reports</a></li>
                <li><a href="settings.php"><i class="fas fa-cog"></i> Settings</a></li>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>
    </div>

    <!-- Content -->
    <div class="content">
        <div class="page-header">
            <h1 class="page-title">Staff Management</h1>
            <a href="add-staff.php" class="btn btn-primary">Add Staff</a>
        </div>
        
        <div class="staff-grid">
            <?php foreach ($staff as $member): ?>
            <div class="staff-card">
                <div class="staff-avatar">
                    <?= strtoupper(substr($member['name'], 0, 1)) ?>
                </div>
                <div class="staff-details">
                    <div class="staff-name"><?= htmlspecialchars($member['name']) ?></div>
                    <div class="staff-position"><?= htmlspecialchars($member['position']) ?></div>
                    <div class="staff-contact">
                        <?= htmlspecialchars($member['email']) ?><br>
                        <?= htmlspecialchars($member['phone']) ?>
                    </div>
                    <span class="staff-status <?= $member['status'] ?>"><?= ucfirst($member['status']) ?></span>
                    <div class="action-buttons">
                        <a href="edit-staff.php?id=<?= $member['id'] ?>" class="btn btn-sm btn-info">Edit</a>
                        <?php if ($member['status'] == 'active'): ?>
                            <a href="update-staff.php?id=<?= $member['id'] ?>&status=inactive" class="btn btn-sm btn-danger">Deactivate</a>
                        <?php else: ?>
                            <a href="update-staff.php?id=<?= $member['id'] ?>&status=active" class="btn btn-sm btn-success">Activate</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>