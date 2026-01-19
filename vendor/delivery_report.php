<?php
include '../includes/db.php';
$user_id = $_SESSION['user_id'];
$v_res = $conn->query("SELECT id FROM vendors WHERE user_id = $user_id");
$vendor_id = $v_res->fetch_assoc()['id'];

// Handle "Mark Delivered" Action
if (isset($_GET['complete_id'])) {
    $id = intval($_GET['complete_id']);
    $conn->query("UPDATE order_items SET status='completed' WHERE id=$id AND vendor_id=$vendor_id");
    header("Location: delivery_report.php");
    exit();
}

// Fetch Accepted (In Progress) and Completed (Delivered)
$query = "
    SELECT oi.*, s.title, u.name as customer, u.email, o.created_at
    FROM order_items oi
    JOIN services s ON oi.service_id = s.id
    JOIN orders o ON oi.order_id = o.id
    JOIN users u ON o.customer_id = u.id
    WHERE oi.vendor_id = $vendor_id AND oi.status IN ('accepted', 'completed')
    ORDER BY field(oi.status, 'accepted', 'completed'), o.created_at DESC
";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Supply & Delivery Report</title>
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        .badge-completed { background: #28a745; color: white; padding: 5px 10px; border-radius: 15px; font-size: 12px; }
        .badge-accepted { background: #17a2b8; color: white; padding: 5px 10px; border-radius: 15px; font-size: 12px; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>🚚 Supply & Delivery Report</h1>
        <a href="dashboard.php" class="btn">⬅ Dashboard</a>
    </div>

    <table>
        <tr>
            <th>Date Ordered</th>
            <th>Customer Info</th>
            <th>Service / Product</th>
            <th>Current Status</th>
            <th>Action</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo date("d M, Y", strtotime($row['created_at'])); ?></td>
            <td>
                <strong><?php echo htmlspecialchars($row['customer']); ?></strong><br>
                <small><?php echo htmlspecialchars($row['email']); ?></small>
            </td>
            <td><?php echo htmlspecialchars($row['title']); ?></td>
            <td>
                <?php if($row['status'] == 'accepted'): ?>
                    <span class="badge-accepted">🚀 In Progress</span>
                <?php else: ?>
                    <span class="badge-completed">🏁 Delivered</span>
                <?php endif; ?>
            </td>
            <td>
                <?php if($row['status'] == 'accepted'): ?>
                    <a href="?complete_id=<?php echo $row['id']; ?>" class="btn" style="background: #28a745;">✅ Mark Delivered</a>
                <?php else: ?>
                    <span style="color: grey;">Completed</span>
                <?php endif; ?>
                <a href="order_details.php?id=<?php echo $row['id']; ?>" class="btn" style="background: #6c757d; font-size: 12px;">📄 View</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>
</body>
</html>