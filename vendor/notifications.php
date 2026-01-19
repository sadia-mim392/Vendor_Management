<?php
include '../includes/db.php';
$user_id = $_SESSION['user_id'];

// Mark all as read when visiting this page
$conn->query("UPDATE notifications SET is_read = 1 WHERE user_id = $user_id");

// Fetch Notifications
$notifs = $conn->query("SELECT * FROM notifications WHERE user_id = $user_id ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Notifications</title>
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        .notif-item { padding: 15px; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center; }
        .notif-item:last-child { border-bottom: none; }
        .time { font-size: 12px; color: #888; }
        .new-badge { background: #dc3545; color: white; padding: 2px 6px; border-radius: 10px; font-size: 10px; margin-left: 10px; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>🔔 Notifications</h1>
        <a href="dashboard.php" class="btn">⬅ Dashboard</a>
    </div>

    <div style="background: white; border: 1px solid #eee; border-radius: 8px;">
        <?php if($notifs->num_rows > 0): ?>
            <?php while($n = $notifs->fetch_assoc()): ?>
            <div class="notif-item">
                <div>
                    <?php echo htmlspecialchars($n['message']); ?>
                    <?php if($n['is_read'] == 0): ?>
                        <span class="new-badge">NEW</span>
                    <?php endif; ?>
                </div>
                <div class="time"><?php echo date("M d, h:i A", strtotime($n['created_at'])); ?></div>
            </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div style="padding: 20px; text-align: center; color: #666;">No notifications yet.</div>
        <?php endif; ?>
    </div>
</div>
</body>
</html>