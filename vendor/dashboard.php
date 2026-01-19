<?php
session_start();
include '../config/db.php';

// Security: Kick out anyone who isn't a vendor
if (!isset($_SESSION['user']['id']) || $_SESSION['user']['role'] !== 'vendor') {
    header("Location: ../views/login.php");
    exit();
}

$user_id = $_SESSION['user']['id'];

// Get Vendor ID
$vendor_query = $conn->prepare("SELECT id, business_name FROM vendors WHERE user_id = ?");
$vendor_query->bind_param("i", $user_id);
$vendor_query->execute();
$vendor = $vendor_query->get_result()->fetch_assoc();
$vendor_id = $vendor['id'];

// Get Stats
$stats = $conn->query("SELECT 
    COUNT(*) as total_orders, 
    SUM(price) as earnings,
    SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending
    FROM order_items WHERE vendor_id = $vendor_id")->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Vendor Dashboard</title>
    <link rel="stylesheet" href="../public/styles/customer_style.css">
</head>
<body>
<div class="container">
    <?php
// Add this query at the TOP of dashboard.php to count unread notifications
$notif_count = $conn->query("SELECT COUNT(*) as c FROM notifications WHERE user_id = $user_id AND is_read = 0")->fetch_assoc()['c'];
?>

<div class="header">
    <h1> Welcome, <?php echo htmlspecialchars($vendor['business_name']); ?></h1>
    <div style="display: flex; align-items: center; gap: 5px;">
        
        <a href="notifications.php" class="btn" style="background: #ffc107; color: #333; position: relative;">
            🔔
            <?php if($notif_count > 0): ?>
                <span style="position: absolute; top: -5px; right: -5px; background: red; color: white; border-radius: 50%; padding: 2px 6px; font-size: 10px;">
                    <?php echo $notif_count; ?>
                </span>
            <?php endif; ?>
        </a>

        <a href="contact_us.php" class="btn" style="background: #6610f2;">📞 Support</a>

        <a href="profile.php" class="btn" style="background: #17a2b8;">⚙️ Settings</a>
        <a href="#" class="btn btn-danger">Log Out</a>
    </div>
</div>

    <div class="grid">
        <div class="card">
            <h3>Total Earnings</h3>
            <p class="money">৳<?php echo number_format($stats['earnings'] ?? 0, 2); ?></p>
            <a href="export_earnings.php" style="font-size: 12px; display: block; margin-top: 5px; color: #007bff;">⬇ Download Report (CSV)</a>
        </div>
        <div class="card">
            <h3>Total Orders</h3>
            <p><?php echo $stats['total_orders']; ?></p>
        </div>
        <a href="pending_orders.php" style="text-decoration: none; color: inherit;">
    <div class="card" style="border: 2px solid #ffc107; background: #fff3cd; cursor: pointer; transition: transform 0.2s;">
        <h3 style="color: #856404;">⚠️ Pending Orders</h3>
        <p style="color: #856404; font-weight: bold;">
            <?php echo $stats['pending']; ?> Action(s) Needed
        </p>
        <small style="color: #856404; text-decoration: underline;">Click to Review</small>
    </div>
</a>
    </div>

    <h3>Quick Actions</h3>
    <div style="display: flex; gap: 10px;">
        <a href="manage_services.php" class="btn">📦 Manage Services</a>
        <a href="bookings.php" class="btn">📅 View Bookings</a>
        <a href="compare.php" class="btn" style="background: #6f42c1;">⚖️ Compare Items</a>
        <a href="../index.php" class="btn" style="background: #6c757d;">🏠 Back to Home</a>
        <a href="reviews.php" class="btn" style="background: #ffc107; color: #333;">⭐ Reviews</a>
        <a href="calendar.php" class="btn" style="background: #17a2b8;">📆 My Calendar</a>
        <a href="delivery_report.php" class="btn" style="background: #20c997;">🚚 Delivery Report</a>
    </div>
</div>
</body>
</html>