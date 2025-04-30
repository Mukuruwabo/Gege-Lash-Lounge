<?php
session_start();
include '../includes/config.php';
include '../includes/db.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: index.php");
    exit;
}

// Get report data
try {
    // Monthly Revenue - Using service price from services table
    $monthlyRevenue = $pdo->query("
        SELECT 
            DATE_FORMAT(b.booking_date, '%Y-%m') as month,
            SUM(s.price) as revenue
        FROM bookings b
        JOIN services s ON b.service_id = s.id
        WHERE b.status = 'confirmed'
        GROUP BY DATE_FORMAT(b.booking_date, '%Y-%m')
        ORDER BY month DESC
        LIMIT 6
    ")->fetchAll(PDO::FETCH_ASSOC);

    // Popular Services
    $popularServices = $pdo->query("
        SELECT 
            s.name,
            COUNT(b.id) as booking_count,
            SUM(s.price) as total_revenue
        FROM services s
        LEFT JOIN bookings b ON s.id = b.service_id AND b.status = 'confirmed'
        GROUP BY s.id
        ORDER BY booking_count DESC
        LIMIT 5
    ")->fetchAll(PDO::FETCH_ASSOC);

    // Client Activity
    $clientActivity = $pdo->query("
        SELECT 
            c.username,
            COUNT(b.id) as booking_count,
            MAX(b.booking_date) as last_booking,
            SUM(s.price) as total_spent
        FROM clients c
        LEFT JOIN bookings b ON c.id = b.client_id AND b.status = 'confirmed'
        LEFT JOIN services s ON b.service_id = s.id
        GROUP BY c.id
        ORDER BY booking_count DESC
        LIMIT 5
    ")->fetchAll(PDO::FETCH_ASSOC);

    // Quick Stats
    $totalRevenue = $pdo->query("
        SELECT SUM(s.price) 
        FROM bookings b
        JOIN services s ON b.service_id = s.id
        WHERE b.status = 'confirmed'
    ")->fetchColumn();
    
    $avgBookingValue = $pdo->query("
        SELECT AVG(s.price) 
        FROM bookings b
        JOIN services s ON b.service_id = s.id
        WHERE b.status = 'confirmed'
    ")->fetchColumn();
    
    $totalClients = $pdo->query("SELECT COUNT(*) FROM clients")->fetchColumn();
    
    $repeatClients = $pdo->query("
        SELECT COUNT(*) 
        FROM (
            SELECT client_id 
            FROM bookings 
            WHERE status = 'confirmed'
            GROUP BY client_id 
            HAVING COUNT(*) > 1
        ) as repeat_clients
    ")->fetchColumn();

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}

// Prepare data for charts
$months = array_reverse(array_column($monthlyRevenue, 'month'));
$revenues = array_reverse(array_column($monthlyRevenue, 'revenue'));

$serviceNames = array_column($popularServices, 'name');
$serviceBookings = array_column($popularServices, 'booking_count');
$serviceRevenues = array_column($popularServices, 'total_revenue');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports - Gege Lash Lounge</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary: #a8a632;
            --dark: #121212;
            --light: #ffffff;
            --gray: #f5f5f5;
            --success: #28a745;
            --danger: #dc3545;
            --info: #17a2b8;
            --warning: #ffc107;
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
        
        /* Report Filters */
        .report-filters {
            background-color: var(--light);
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }
        
        .filter-group {
            flex: 1;
            min-width: 200px;
        }
        
        .filter-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }
        
        .filter-group select,
        .filter-group input {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        
        .filter-actions {
            display: flex;
            align-items: flex-end;
            gap: 10px;
        }
        
        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background-color: var(--light);
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .stat-title {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 10px;
        }
        
        .stat-value {
            font-size: 1.8rem;
            font-weight: 600;
        }
        
        /* Charts */
        .chart-container {
            background-color: var(--light);
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .chart-title {
            font-size: 1.2rem;
            margin-bottom: 20px;
            color: var(--dark);
        }
        
        .chart-wrapper {
            height: 300px;
            position: relative;
        }
        
        /* Tables */
        .report-table {
            width: 100%;
            border-collapse: collapse;
            background: var(--light);
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .report-table thead {
            background-color: var(--primary);
            color: white;
        }
        
        .report-table th {
            padding: 15px;
            text-align: left;
            font-weight: 500;
        }
        
        .report-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
        }
        
        .report-table tr:last-child td {
            border-bottom: none;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 70px;
            }
            
            .sidebar-header h3,
            .sidebar-menu li a span {
                display: none;
            }
            
            .content {
                margin-left: 70px;
                padding: 15px;
            }
            
            .report-filters {
                flex-direction: column;
            }
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
                <li><a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a></li>
                <li><a href="bookings.php"><i class="fas fa-calendar-check"></i> <span>Bookings</span></a></li>
                <li><a href="clients.php"><i class="fas fa-users"></i> <span>Clients</span></a></li>
                <li><a href="staff.php"><i class="fas fa-user-tie"></i> <span>Staff</span></a></li>
                <li><a href="reports.php" class="active"><i class="fas fa-chart-bar"></i> <span>Reports</span></a></li>
                <li><a href="settings.php"><i class="fas fa-cog"></i> <span>Settings</span></a></li>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></a></li>
            </ul>
        </div>
    </div>

    <!-- Content -->
    <div class="content">
        <div class="page-header">
            <h1 class="page-title">Reports & Analytics</h1>
        </div>
        
        <!-- Report Filters -->
        <form class="report-filters">
            <div class="filter-group">
                <label for="report-period">Period</label>
                <select id="report-period" class="form-control">
                    <option value="last6">Last 6 Months</option>
                    <option value="this_year">This Year</option>
                    <option value="last_year">Last Year</option>
                    <option value="custom">Custom Range</option>
                </select>
            </div>
            <div class="filter-group">
                <label for="start-date">Start Date</label>
                <input type="date" id="start-date" class="form-control">
            </div>
            <div class="filter-group">
                <label for="end-date">End Date</label>
                <input type="date" id="end-date" class="form-control">
            </div>
            <div class="filter-actions">
                <button type="submit" class="btn btn-primary">Generate Report</button>
                <button type="button" class="btn">Export</button>
            </div>
        </form>
        
        <!-- Quick Stats -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-title">Total Revenue</div>
                <div class="stat-value"><?= number_format($totalRevenue) ?> RWF</div>
            </div>
            <div class="stat-card">
                <div class="stat-title">Avg. Booking Value</div>
                <div class="stat-value"><?= number_format($avgBookingValue, 2) ?> RWF</div>
            </div>
            <div class="stat-card">
                <div class="stat-title">Total Clients</div>
                <div class="stat-value"><?= number_format($totalClients) ?></div>
            </div>
            <div class="stat-card">
                <div class="stat-title">Repeat Clients</div>
                <div class="stat-value"><?= number_format($repeatClients) ?></div>
            </div>
        </div>
        
        <!-- Monthly Revenue Chart -->
        <div class="chart-container">
            <h2 class="chart-title">Monthly Revenue</h2>
            <div class="chart-wrapper">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
        
        <!-- Popular Services Chart -->
        <div class="chart-container">
            <h2 class="chart-title">Popular Services</h2>
            <div class="chart-wrapper">
                <canvas id="servicesChart"></canvas>
            </div>
        </div>
        
        <!-- Top Clients Table -->
        <div class="chart-container">
            <h2 class="chart-title">Top Clients</h2>
            <table class="report-table">
                <thead>
                    <tr>
                        <th>Client</th>
                        <th>Bookings</th>
                        <th>Last Booking</th>
                        <th>Total Spent</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clientActivity as $client): ?>
                    <tr>
                        <td><?= htmlspecialchars($client['username']) ?></td>
                        <td><?= $client['booking_count'] ?></td>
                        <td><?= $client['last_booking'] ? date('M j, Y', strtotime($client['last_booking'])) : 'Never' ?></td>
                        <td><?= number_format($client['total_spent']) ?> RWF</td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Monthly Revenue Chart
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        const revenueChart = new Chart(revenueCtx, {
            type: 'bar',
            data: {
                labels: <?= json_encode($months) ?>,
                datasets: [{
                    label: 'Revenue (RWF)',
                    data: <?= json_encode($revenues) ?>,
                    backgroundColor: 'rgba(168, 166, 50, 0.7)',
                    borderColor: 'rgba(168, 166, 50, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString() + ' RWF';
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.parsed.y.toLocaleString() + ' RWF';
                            }
                        }
                    }
                }
            }
        });
        
        // Popular Services Chart
        const servicesCtx = document.getElementById('servicesChart').getContext('2d');
        const servicesChart = new Chart(servicesCtx, {
            type: 'doughnut',
            data: {
                labels: <?= json_encode($serviceNames) ?>,
                datasets: [{
                    data: <?= json_encode($serviceBookings) ?>,
                    backgroundColor: [
                        'rgba(168, 166, 50, 0.7)',
                        'rgba(40, 167, 69, 0.7)',
                        'rgba(23, 162, 184, 0.7)',
                        'rgba(255, 193, 7, 0.7)',
                        'rgba(220, 53, 69, 0.7)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = Math.round((value / total) * 100);
                                return `${label}: ${value} bookings (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });
        
        // Filter form handling
        document.querySelector('.report-filters').addEventListener('submit', function(e) {
            e.preventDefault();
            // In a real implementation, this would reload the page with new filters
            alert('Report filters would be applied here in a full implementation');
        });
        
        // Show/hide custom date range based on selection
        document.getElementById('report-period').addEventListener('change', function() {
            const customDates = document.querySelectorAll('.filter-group input[type="date"]');
            const isCustom = this.value === 'custom';
            
            customDates.forEach(input => {
                input.parentElement.style.display = isCustom ? 'block' : 'none';
            });
        });
    </script>
</body>
</html>