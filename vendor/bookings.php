<?php
session_start();
include '../config/db.php';

/* ===== FIX 1: SESSION VARIABLE (MATCH YOUR PROJECT) ===== */
$user_id = $_SESSION['user']['id'];   // ❌ was $_SESSION['user_id']

/* ===== FIX 2: SAFE VENDOR FETCH ===== */
$v_res = $conn->query("SELECT id FROM vendors WHERE user_id = $user_id");
if (!$v_res || $v_res->num_rows == 0) {
    die("Vendor not found");
}
$vendor_id = $v_res->fetch_assoc()['id'];

/* ===== HANDLE ACTIONS (UNCHANGED LOGIC) ===== */
if (isset($_GET['action'])) {
    $status = ($_GET['action'] == 'accept') ? 'accepted' : 'rejected';
    $id = intval($_GET['id']);

    $conn->query("
        UPDATE order_items 
        SET status='$status' 
        WHERE id=$id AND vendor_id=$vendor_id
    ");
}

/* ===== FIX 3: PRICE COMES FROM SERVICES TABLE ===== */
$bookings = $conn->query("
    SELECT 
        oi.*, 
        s.title, 
        s.price,
        u.name AS customer 
    FROM order_items oi
    JOIN services s ON oi.service_id = s.id
    JOIN orders o ON oi.order_id = o.id
    JOIN users u ON o.customer_id = u.id
    WHERE oi.vendor_id = $vendor_id
    ORDER BY o.created_at DESC
");
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="../assets/style.css">
</head>

<body>

    <div class="container">
        <div class="header">
            <h1>📅 Booking Requests</h1>
            <a href="dashboard.php" class="btn">⬅ Dashboard</a>
        </div>

        <table>
            <tr>
                <th>Customer</th>
                <th>Service</th>
                <th>Price</th>
                <th>Status</th>
                <th>Action</th>
            </tr>

            <?php while ($b = $bookings->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($b['customer']); ?></td>
                    <td><?php echo htmlspecialchars($b['title']); ?></td>
                    <td>৳<?php echo number_format($b['price'], 2); ?></td>

                    <td>
                        <span class="badge badge-<?php echo $b['status']; ?>">
                            <?php echo strtoupper($b['status']); ?>
                        </span>
                    </td>

                    <!-- FIX 4: REMOVED NESTED <td> -->
                    <td>
                        <a href="order_details.php?id=<?php echo $b['id']; ?>"
                            class="btn" style="background:#17a2b8;">📄 View</a>

                        <?php if ($b['status'] == 'pending'): ?>
                            <a href="?action=accept&id=<?php echo $b['id']; ?>"
                                class="btn btn-success">✅ Accept</a>

                            <a href="?action=reject&id=<?php echo $b['id']; ?>"
                                class="btn btn-danger">❌ Reject</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>

</body>

</html>