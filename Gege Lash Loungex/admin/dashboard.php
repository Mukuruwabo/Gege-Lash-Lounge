<?php
require_once 'auth-check.php';

// Ensure admin_id is set in session
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

require_once '../includes/config.php';
require_once '../includes/db.php';

// Get booking statistics using prepared statements
$totalBookings = $pdo->query("SELECT COUNT(*) FROM bookings")->fetchColumn();
$confirmedBookings = $pdo->query("SELECT COUNT(*) FROM bookings WHERE status = 'confirmed'")->fetchColumn();
$pendingBookings = $pdo->query("SELECT COUNT(*) FROM bookings WHERE status = 'pending'")->fetchColumn();
$cancelledBookings = $pdo->query("SELECT COUNT(*) FROM bookings WHERE status = 'cancelled'")->fetchColumn();

// Get recent bookings (last 5) with prepared statement
$stmt = $pdo->prepare("
    SELECT b.*, c.username as client_name, c.phone as client_phone, s.name as service_type
    FROM bookings b
    JOIN clients c ON b.client_id = c.id
    JOIN services s ON b.service_id = s.id
    ORDER BY b.created_at DESC 
    LIMIT 5
");
$stmt->execute();
$recentBookings = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Initialize notifications variables
$notifications = [];
$unreadCount = 0;

// Check if notifications table exists before querying
try {
    $stmt = $pdo->prepare("
        SELECT 
            n.*,
            c.username as client_name,
            b.service_id,
            s.name as service_name
        FROM notifications n
        LEFT JOIN bookings b ON n.booking_id = b.id
        LEFT JOIN clients c ON b.client_id = c.id
        LEFT JOIN services s ON b.service_id = s.id
        WHERE n.admin_id = ?
        ORDER BY n.is_read ASC, n.created_at DESC
        LIMIT 10
    ");
    $stmt->execute([$_SESSION['admin_id']]);
    $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM notifications WHERE admin_id = ? AND is_read = 0");
    $stmt->execute([$_SESSION['admin_id']]);
    $unreadCount = $stmt->fetchColumn();
} catch (PDOException $e) {
    error_log("Notifications not available: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Gege Lash Lounge</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
    :root {
        --primary:rgb(182, 179, 6);
        --secondary: #6c757d;
        --dark: #343a40;
        --light: #f8f9fa;
        --success: #28a745;
        --danger: #dc3545;
        --warning: #ffc107;
        --info: #17a2b8;
    }
    
    body {
        font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 
                     'Helvetica Neue', Arial, sans-serif;
        font-weight: 400;
        line-height: 1.6;
        color: #333;
        background-color: #f5f5f5;
    }
    
    h1, h2, h3, h4, h5, h6 {
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        color: var(--dark);
    }
    
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
    
    /* Content Area Styles */
    .content-area {
        flex: 1;
        margin-left: 250px;
        padding: 20px;
    }
    
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        padding-bottom: 15px;
        border-bottom: 1px solid #e0e0e0;
    }
    
    .page-title {
        font-size: 1.8rem;
        color: var(--dark);
    }
    
    .breadcrumb {
        list-style: none;
        display: flex;
    }
    
    .breadcrumb-item {
        margin-right: 10px;
        font-size: 0.9rem;
    }
    
    .breadcrumb-item:not(:last-child):after {
        content: '/';
        margin-left: 10px;
        color: #999;
    }
    
    /* Notification Bell */
    .notification-container {
        position: relative;
        margin-left: 20px;
    }
    
    .notification-bell {
        font-size: 1.2rem;
        color: var(--dark);
        cursor: pointer;
    }
    
    .notification-badge {
        position: absolute;
        top: -5px;
        right: -5px;
        background-color: var(--primary);
        color: white;
        border-radius: 50%;
        width: 18px;
        height: 18px;
        font-size: 0.7rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    /* Notification Dropdown */
    .notification-dropdown {
        display: none;
        position: absolute;
        right: 0;
        top: 100%;
        width: 350px;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        z-index: 1000;
        max-height: 400px;
        overflow-y: auto;
    }
    
    .notification-dropdown.show {
        display: block;
    }
    
    .notification-header {
        padding: 15px;
        border-bottom: 1px solid #eee;
        font-weight: 600;
        display: flex;
        justify-content: space-between;
    }
    
    .notification-item {
        padding: 12px 15px;
        border-bottom: 1px solid #f5f5f5;
        transition: background-color 0.2s;
    }
    
    .notification-item:hover {
        background-color: #f9f9f9;
    }
    
    .notification-item.unread {
        background-color: rgba(168, 166, 50, 0.1);
    }
    
    .notification-time {
        font-size: 0.75rem;
        color: #6c757d;
        margin-top: 3px;
    }
    
    /* Stats Cards */
    .stats-cards {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }
    
    .stat-card {
        background-color: var(--light);
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        position: relative;
        overflow: hidden;
        transition: transform 0.3s;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
    }
    
    .stat-title {
        font-size: 0.9rem;
        color: #666;
        margin-bottom: 5px;
    }
    
    .stat-value {
        font-size: 1.8rem;
        font-weight: 600;
        margin-bottom: 10px;
        color: var(--dark);
    }
    
    .stat-change {
        font-size: 0.8rem;
        display: flex;
        align-items: center;
    }
    
    .stat-change i {
        margin-right: 5px;
    }
    
    .stat-change.up {
        color: #28a745;
    }
    
    .stat-change.down {
        color: #dc3545;
    }
    
    .stat-icon {
        position: absolute;
        right: 20px;
        top: 20px;
        font-size: 2.5rem;
        opacity: 100;
        color: var(--primary);
    }
    
    /* Recent Bookings Table */
    .recent-activity {
        background-color: var(--light);
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 30px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    }
    
    .recent-activity h2 {
        font-size: 1.3rem;
        margin-bottom: 20px;
        color: var(--dark);
        padding-bottom: 10px;
        border-bottom: 1px solid #eee;
    }
    
    /* Booking Table Styles */
    .booking-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        margin-top: 15px;
        background: var(--light);
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    
    .booking-table thead {
        background-color: var(--primary);
        color: var(--light);
    }
    
    .booking-table th {
        padding: 15px;
        text-align: left;
        font-weight: 500;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
    }
    
    .booking-table td {
        padding: 15px;
        border-bottom: 1px solid #f0f0f0;
        vertical-align: middle;
    }
    
    .booking-table tr:last-child td {
        border-bottom: none;
    }
    
    .booking-table tr:hover {
        background-color: rgba(168, 166, 50, 0.05);
    }
    
    .status-badge {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .status-badge.pending {
        background-color: rgba(255, 193, 7, 0.2);
        color: #ffc107;
    }
    
    .status-badge.confirmed {
        background-color: rgba(40, 167, 69, 0.2);
        color: #28a745;
    }
    
    .status-badge.cancelled {
        background-color: rgba(220, 53, 69, 0.2);
        color: #dc3545;
    }
    
    .action-buttons {
        display: flex;
        gap: 8px;
    }
    
    .action-buttons button {
        padding: 6px 12px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 0.75rem;
        font-weight: 500;
        transition: all 0.2s;
    }
    
    .btn-confirm {
        background-color: #28a745;
        color: white;
    }
    
    .btn-confirm:hover {
        background-color: #218838;
    }
    
    .btn-cancel {
        background-color: #dc3545;
        color: white;
    }
    
    .btn-cancel:hover {
        background-color: #c82333;
    }
    
    .btn-view {
        background-color: var(--primary);
        color: white;
    }
    
    .btn-view:hover {
        background-color: #8f8a2a;
    }
    
    .text-muted {
        color: #6c757d;
        font-size: 0.85rem;
        margin-top: 3px;
    }
    
    .no-notifications {
        padding: 15px;
        text-align: center;
        color: #6c757d;
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
                <li><a href="dashboard.php" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="bookings.php"><i class="fas fa-calendar-alt"></i> Bookings</a></li>
                <li><a href="clients.php"><i class="fas fa-users"></i> Clients</a></li>
                <li><a href="reports.php"><i class="fas fa-chart-bar"></i> Reports</a></li>
                <li><a href="settings.php"><i class="fas fa-cog"></i> Settings</a></li>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>
    </div>

    <!-- Content Area -->
    <div class="content-area">
        <div class="page-header">
            <h1 class="page-title">Dashboard</h1>
            <div class="notification-container">
                <div class="notification-bell" id="notificationBell">
                    <i class="fas fa-bell"></i>
                    <?php if ($unreadCount > 0): ?>
                        <span class="notification-badge"><?= htmlspecialchars($unreadCount) ?></span>
                    <?php endif; ?>
                </div>
                <div class="notification-dropdown" id="notificationDropdown">
                    <div class="notification-header">
                        <span>Notifications</span>
                        <span id="markAllRead"><small>Mark all as read</small></span>
                    </div>
                    <?php if (count($notifications) > 0): ?>
                        <?php foreach ($notifications as $notification): ?>
                            <div class="notification-item <?= $notification['is_read'] ? '' : 'unread' ?>" 
                                 data-id="<?= htmlspecialchars($notification['id']) ?>">
                                <div class="notification-message">
                                    <div class="notification-icon">
                                        <i class="fas fa-<?= $notification['type'] === 'booking' ? 'calendar-check' : 'user' ?>"></i>
                                    </div>
                                    <div>
                                        <?= htmlspecialchars($notification['message']) ?>
                                        <?php if (!empty($notification['service_name'])): ?>
                                            <br><small>Service: <?= htmlspecialchars($notification['service_name']) ?></small>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="notification-time">
                                    <?= date('M j, g:i A', strtotime($notification['created_at'])) ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="no-notifications">No notifications</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="stats-cards">
            <div class="stat-card">
                <div class="stat-title">Total Bookings</div>
                <div class="stat-value"><?= htmlspecialchars($totalBookings) ?></div>
                <div class="stat-change">
                    <i class="fas fa-chart-line"></i> All bookings
                </div>
                <div class="stat-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-title">Confirmed</div>
                <div class="stat-value"><?= htmlspecialchars($confirmedBookings) ?></div>
                <div class="stat-change up">
                    <i class="fas fa-arrow-up"></i> Ready for service
                </div>
                <div class="stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-title">Pending</div>
                <div class="stat-value"><?= htmlspecialchars($pendingBookings) ?></div>
                <div class="stat-change">
                    <i class="fas fa-clock"></i> Need confirmation
                </div>
                <div class="stat-icon">
                    <i class="fas fa-hourglass-half"></i>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-title">Cancelled</div>
                <div class="stat-value"><?= htmlspecialchars($cancelledBookings) ?></div>
                <div class="stat-change down">
                    <i class="fas fa-arrow-down"></i> Cancellations
                </div>
                <div class="stat-icon">
                    <i class="fas fa-times-circle"></i>
                </div>
            </div>
        </div>

        <!-- Recent Bookings Table -->
        <div class="recent-activity">
            <h2>Recent Bookings</h2>
            <div class="table-responsive">
                <table class="booking-table">
                    <thead>
                        <tr>
                            <th>Client</th>
                            <th>Service</th>
                            <th>Date & Time</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentBookings as $booking): ?>
                        <tr>
                            <td>
                                <strong><?= htmlspecialchars($booking['client_name']) ?></strong>
                                <div class="text-muted"><?= htmlspecialchars($booking['client_phone']) ?></div>
                            </td>
                            <td><?= htmlspecialchars($booking['service_type']) ?></td>
                            <td>
                                <?= date('M j, Y', strtotime($booking['booking_date'])) ?>
                                <div class="text-muted"><?= date('g:i A', strtotime($booking['booking_time'])) ?></div>
                            </td>
                            <td>
                                <span class="status-badge <?= htmlspecialchars($booking['status']) ?>">
                                    <?= ucfirst(htmlspecialchars($booking['status'])) ?>
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <?php if ($booking['status'] == 'pending'): ?>
                                        <button class="btn-confirm" data-id="<?= htmlspecialchars($booking['id']) ?>">Confirm</button>
                                        <button class="btn-cancel" data-id="<?= htmlspecialchars($booking['id']) ?>">Cancel</button>
                                    <?php endif; ?>
                                    <button class="btn-view" data-id="<?= htmlspecialchars($booking['id']) ?>">View</button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
                                    </div>
    <script>
// Notification system
const notificationBell = document.getElementById('notificationBell');
const notificationDropdown = document.getElementById('notificationDropdown');
const markAllRead = document.getElementById('markAllRead');

// Toggle dropdown
notificationBell.addEventListener('click', function(e) {
    e.stopPropagation();
    notificationDropdown.classList.toggle('show');
});

// Close dropdown when clicking outside
document.addEventListener('click', function() {
    notificationDropdown.classList.remove('show');
});

// Mark notification as read when clicked
document.querySelectorAll('.notification-item').forEach(item => {
    item.addEventListener('click', function() {
        const notificationId = this.getAttribute('data-id');
        if (this.classList.contains('unread')) {
            markNotificationAsRead(notificationId);
            this.classList.remove('unread');
            updateBadgeCount();
        }
    });
});

// Mark all as read
markAllRead.addEventListener('click', function(e) {
    e.preventDefault();
    markAllNotificationsAsRead();
    document.querySelectorAll('.notification-item.unread').forEach(item => {
        item.classList.remove('unread');
    });
    updateBadgeCount(true);
});

// Update badge count
function updateBadgeCount(removeAll = false) {
    const notificationBadge = document.querySelector('.notification-badge');
    if (removeAll) {
        if (notificationBadge) notificationBadge.remove();
        return;
    }
    
    const currentCount = notificationBadge ? parseInt(notificationBadge.textContent) : 0;
    const newCount = currentCount - 1;
    
    if (newCount <= 0) {
        if (notificationBadge) notificationBadge.remove();
    } else {
        if (notificationBadge) {
            notificationBadge.textContent = newCount;
        } else {
            createBadge(newCount);
        }
    }
}

function createBadge(count) {
    const badge = document.createElement('span');
    badge.className = 'notification-badge';
    badge.textContent = count;
    notificationBell.appendChild(badge);
}

// AJAX functions
function markNotificationAsRead(notificationId) {
    fetch('mark_notification_read.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ id: notificationId })
    })
    .catch(error => console.error('Error:', error));
}

function markAllNotificationsAsRead() {
    fetch('mark_all_notifications_read.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        }
    })
    .catch(error => console.error('Error:', error));
}

// Improved booking status update with loading states
document.querySelectorAll('.btn-confirm').forEach(btn => {
    btn.addEventListener('click', async function() {
        const bookingId = this.getAttribute('data-id');
        await updateBookingStatus(bookingId, 'confirmed', this);
    });
});

document.querySelectorAll('.btn-cancel').forEach(btn => {
    btn.addEventListener('click', async function() {
        const bookingId = this.getAttribute('data-id');
        await updateBookingStatus(bookingId, 'cancelled', this);
    });
});

async function updateBookingStatus(bookingId, status, button) {
    const originalText = button.textContent;
    button.disabled = true;
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing';
    
    try {
        const response = await fetch('update-booking.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `id=${bookingId}&status=${status}`
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();
        
        if (data.success) {
            const row = button.closest('tr');
            const statusBadge = row.querySelector('.status-badge');
            
            // Update UI
            statusBadge.className = `status-badge ${status}`;
            statusBadge.textContent = status.charAt(0).toUpperCase() + status.slice(1);
            
            // Update action buttons
            if (status !== 'pending') {
                const actionButtons = row.querySelector('.action-buttons');
                actionButtons.innerHTML = `<button class="btn-view" data-id="${bookingId}">View</button>`;
            }
            
            showAlert('success', 'Booking status updated successfully');
        } else {
            throw new Error(data.message || 'Failed to update booking status');
        }
    } catch (error) {
        console.error('Error:', error);
        showAlert('error', error.message);
        button.textContent = originalText;
    } finally {
        button.disabled = false;
    }
}

function showAlert(type, message) {
    // Remove any existing alerts first
    document.querySelectorAll('.status-alert').forEach(el => el.remove());
    
    const alert = document.createElement('div');
    alert.className = `status-alert alert-${type}`;
    alert.innerHTML = `
        <div style="display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
            <span>${message}</span>
        </div>
    `;
    
    // Styling
    Object.assign(alert.style, {
        position: 'fixed',
        top: '20px',
        right: '20px',
        padding: '15px 20px',
        borderRadius: '4px',
        color: 'white',
        backgroundColor: type === 'success' ? '#28a745' : '#dc3545',
        zIndex: '10000',
        boxShadow: '0 2px 10px rgba(0,0,0,0.1)',
        display: 'flex',
        alignItems: 'center',
        animation: 'fadeIn 0.3s ease-in-out'
    });
    
    document.body.appendChild(alert);
    
    setTimeout(() => {
        alert.style.animation = 'fadeOut 0.5s ease-in-out';
        setTimeout(() => alert.remove(), 500);
    }, 3000);
}

// Add some animation styles
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeOut {
        from { opacity: 1; transform: translateY(0); }
        to { opacity: 0; transform: translateY(-20px); }
    }
`;
document.head.appendChild(style);

// Real-time updates with Server-Sent Events
function setupEventSource() {
    const eventSource = new EventSource('notification_stream.php');
    
    eventSource.onmessage = function(e) {
        const data = JSON.parse(e.data);
        if (data.type === 'new_notification') {
            updateNotifications();
        }
    };
    
    eventSource.onerror = function() {
        eventSource.close();
        setTimeout(setupEventSource, 5000);
    };
}

function updateNotifications() {
    fetch('get_notifications.php')
        .then(response => response.json())
        .then(data => {
            if (data.unreadCount > 0) {
                const badge = document.querySelector('.notification-badge');
                if (!badge) {
                    createBadge(data.unreadCount);
                } else {
                    badge.textContent = data.unreadCount;
                }
            } else {
                const badge = document.querySelector('.notification-badge');
                if (badge) badge.remove();
            }
        });
}

// Initialize
setupEventSource();
</script>

   
</body>
</html>