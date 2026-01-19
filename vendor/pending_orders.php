<?php
include '../includes/db.php';
$user_id = $_SESSION['user_id'];
$v_res = $conn->query("SELECT id FROM vendors WHERE user_id = $user_id");
$vendor_id = $v_res->fetch_assoc()['id'];

// Handle Actions (Accept/Reject directly from this report)
if (isset($_GET['action']) && isset($_GET['id'])) {
    $status = $_GET['action'] == 'accept' ? 'accepted' : 'rejected';
    $id = intval($_GET['id']);
    $conn->query("UPDATE order_items SET status='$status' WHERE id=$id AND vendor_id=$vendor_id");
    header("Location: pending_orders.php"); // Refresh list
    exit();
}

// Fetch ONLY Pending Orders
$query = "
    SELECT oi.*, s.title, u.name as customer, o.created_at
    FROM order_items oi
    JOIN services s ON oi.service_id = s.id
    JOIN orders o ON oi.order_id = o.id
    JOIN users u ON o.customer_id = u.id
    WHERE oi.vendor_id = $vendor_id AND oi.status = 'pending'
    ORDER BY o.created_at ASC
";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pending Orders Report</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<div class="container">
    <div class="header">
        <h1>⏳ Pending Orders Report</h1>
        <a href="dashboard.php" class="btn">⬅ Dashboard</a>
    </div>

    <?php if ($result->num_rows > 0): ?>
        <table border="1">
            <tr style="background: #fff3cd;">
                <th>Date</th>
                <th>Customer</th>
                <th>Service Requested</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo date("d M Y", strtotime($row['created_at'])); ?></td>
                <td><?php echo htmlspecialchars($row['customer']); ?></td>
                <td><?php echo htmlspecialchars($row['title']); ?></td>
                <td>৳<?php echo number_format($row['price'], 2); ?></td>
                <td>
                    <a href="?action=accept&id=<?php echo $row['id']; ?>" class="btn btn-success">✅ Approve</a>
                    <a href="?action=reject&id=<?php echo $row['id']; ?>" class="btn btn-danger">❌ Deny</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <div style="padding: 40px; text-align: center; color: #888; background: #f9f9f9; border-radius: 8px;">
            <h3>No pending orders!</h3>
            <p>You are all caught up.</p>
        </div>
    <?php endif; ?>
</div>
</body>
</html>