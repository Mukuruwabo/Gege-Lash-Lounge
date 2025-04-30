<?php
session_start();
include '../includes/config.php';
include '../includes/db.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: index.php");
    exit;
}

$clients = $pdo->query("
    SELECT c.*, COUNT(b.id) as booking_count 
    FROM clients c 
    LEFT JOIN bookings b ON c.id = b.client_id 
    GROUP BY c.id 
    ORDER BY c.created_at DESC
")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clients - Gege Lash Lounge</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #a8a632;
            --dark: #121212;
            --light: #ffffff;
            --gray: #f5f5f5;
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
        
        /* Table */
        .clients-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .clients-table thead {
            background-color: var(--primary);
            color: white;
        }
        
        .clients-table th {
            padding: 15px;
            text-align: left;
            font-weight: 500;
        }
        
        .clients-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
        }
        
        .clients-table tr:last-child td {
            border-bottom: none;
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
        
        .action-buttons {
            display: flex;
            gap: 5px;
        }
        
        /* Search */
        .search-box {
            position: relative;
            margin-bottom: 20px;
        }
        
        .search-box input {
            width: 100%;
            padding: 10px 15px 10px 35px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        
        .search-box i {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #777;
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
                <li><a href="clients.php" class="active"><i class="fas fa-users"></i> Clients</a></li>
                <li><a href="reports.php"><i class="fas fa-chart-bar"></i> Reports</a></li>
                <li><a href="settings.php"><i class="fas fa-cog"></i> Settings</a></li>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>
    </div>

    <!-- Content -->
    <div class="content">
        <div class="page-header">
            <h1 class="page-title">Clients Management</h1>
            <a href="add-client.php" class="btn btn-primary">Add Client</a>
        </div>
        
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" id="search-input" placeholder="Search clients...">
        </div>
        
        <table class="clients-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Contact</th>
                    <th>Bookings</th>
                    <th>Joined</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clients as $client): ?>
                <tr class="client-row">
                    <td><?= htmlspecialchars($client['username']) ?></td>
                    <td>
                        <?= htmlspecialchars($client['email']) ?><br>
                        <?= htmlspecialchars($client['phone']) ?>
                    </td>
                    <td><?= $client['booking_count'] ?></td>
                    <td><?= date('M j, Y', strtotime($client['created_at'])) ?></td>
                    <td>
                        <div class="action-buttons">
                            <a href="client-details.php?id=<?= $client['id'] ?>" class="btn btn-sm btn-info">View</a>
                            <a href="edit-client.php?id=<?= $client['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script>
        // Simple client search
        document.getElementById('search-input').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('.client-row');
            
            rows.forEach(row => {
                const name = row.cells[0].textContent.toLowerCase();
                const email = row.cells[1].textContent.toLowerCase();
                
                if (name.includes(searchTerm) || email.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>