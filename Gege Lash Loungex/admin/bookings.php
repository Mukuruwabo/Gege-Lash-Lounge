<?php
session_start();
include '../includes/config.php';
include '../includes/db.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: index.php");
    exit;
}

$bookings = $pdo->query("
    SELECT b.*, c.username, c.phone, c.email, s.name as service_name, s.price 
    FROM bookings b
    JOIN clients c ON b.client_id = c.id
    JOIN services s ON b.service_id = s.id
    ORDER BY b.booking_date DESC, b.booking_time DESC
")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookings - Gege Lash Lounge</title>
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
        font-family: 'Poppins', sans-serif;
    }
    
    .sidebar-header h3 {
        font-weight: 600;
        letter-spacing: 0.5px;
    }
    
    .sidebar-menu a {
        font-weight: 500;
    }
    
    .stat-card .stat-title {
        font-weight: 500;
        font-size: 0.9rem;
    }
    
    .stat-card .stat-value {
        font-weight: 600;
        font-size: 1.8rem;
    }
    
    .table-responsive {
        font-family: 'Poppins', sans-serif;
    }
    
    .booking-table th {
        font-weight: 600;
    }
    
    .status-badge {
        font-weight: 500;
        font-size: 0.8rem;
    }
    
    .notification-message {
        font-size: 0.9rem;
        line-height: 1.4;
    }
    
    .notification-time {
        font-family: 'Poppins', sans-serif;
    }
    
    :root {
        --primary: #a8a632;
        --dark: #121212;
        --light: #ffffff;
        --gray: #f5f5f5;
        --dark-gray: #333333;
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
    
    /* Sidebar Styles */
    .sidebar {
        width: 250px;
        background-color: var(--dark);
        color: var(--light);
        height: 100vh;
        position: fixed;
        padding: 20px 0;
        transition: all 0.3s;
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
        transition: all 0.3s;
    }
    
    .sidebar-menu li a:hover,
    .sidebar-menu li a.active {
        background-color: rgba(168, 166, 50, 0.2);
        color: var(--primary);
    }
    
    .sidebar-menu li a i {
        margin-right: 10px;
        width: 20px;
        text-align: center;
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
        
        /* Table */
        .bookings-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .bookings-table thead {
            background-color: var(--primary);
            color: white;
        }
        
        .bookings-table th {
            padding: 15px;
            text-align: left;
            font-weight: 500;
        }
        
        .bookings-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
        }
        
        .bookings-table tr:last-child td {
            border-bottom: none;
        }
        
        /* Status */
        .status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        .status.pending {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .status.confirmed {
            background-color: #d4edda;
            color: #155724;
        }
        
        .status.cancelled {
            background-color: #f8d7da;
            color: #721c24;
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
        
        .btn-success {
            background-color: var(--success);
            color: white;
        }
        
        .btn-danger {
            background-color: var(--danger);
            color: white;
        }
        
        .btn-info {
            background-color: var(--info);
            color: white;
        }
        
        .action-buttons {
            display: flex;
            gap: 5px;
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
                <li><a href="bookings.php" class="active"><i class="fas fa-calendar-check"></i> Bookings</a></li>
                <li><a href="clients.php"><i class="fas fa-users"></i> Clients</a></li>
                <li><a href="reports.php"><i class="fas fa-chart-bar"></i> Reports</a></li>
                <li><a href="settings.php"><i class="fas fa-cog"></i> Settings</a></li>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>
    </div>

    <!-- Content -->
    <div class="content">
        <div class="page-header">
            <h1 class="page-title">Bookings Management</h1>
            <a href="add-booking.php" class="btn btn-primary">Add Booking</a>
        </div>
        
        <table class="bookings-table">
            <thead>
                <tr>
                    <th>Client</th>
                    <th>Contact</th>
                    <th>Service</th>
                    <th>Date & Time</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bookings as $booking): ?>
                <tr>
                    <td><?= htmlspecialchars($booking['username']) ?></td>
                    <td>
                        <?= htmlspecialchars($booking['phone']) ?><br>
                        <?= htmlspecialchars($booking['email']) ?>
                    </td>
                    <td><?= htmlspecialchars($booking['service_name']) ?></td>
                    <td>
                        <?= date('M j, Y', strtotime($booking['booking_date'])) ?><br>
                        <?= $booking['booking_time'] ?>
                    </td>
                    <td>
                        <span class="status <?= $booking['status'] ?>">
                            <?= ucfirst($booking['status']) ?>
                        </span>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <?php if ($booking['status'] == 'pending'): ?>
                                <a href="update-booking.php?id=<?= $booking['id'] ?>&status=confirmed" class="btn btn-sm btn-success">Confirm</a>
                                <a href="update-booking.php?id=<?= $booking['id'] ?>&status=cancelled" class="btn btn-sm btn-danger">Cancel</a>
                            <?php endif; ?>
                            <a href="view-booking.php?id=<?= $booking['id'] ?>" class="btn btn-sm btn-info">View</a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>