<?php
include '../includes/db.php';
$user_id = $_SESSION['user_id'];

// Security: If no ID is provided, go back
if (!isset($_GET['id'])) { header("Location: bookings.php"); exit(); }
$item_id = intval($_GET['id']);

// Fetch Order Details linked to this Vendor
$query = "
    SELECT oi.*, s.title as service_name, s.price as unit_price, u.name as customer, u.email, o.created_at, v.business_name
    FROM order_items oi
    JOIN services s ON oi.service_id = s.id
    JOIN orders o ON oi.order_id = o.id
    JOIN users u ON o.customer_id = u.id
    JOIN vendors v ON oi.vendor_id = v.id
    WHERE oi.id = $item_id AND v.user_id = $user_id
";
$result = $conn->query($query);

// Security: If order doesn't belong to you, stop.
if ($result->num_rows == 0) { die("Order not found or access denied."); }
$order = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Invoice #<?php echo $order['id']; ?></title>
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        .invoice-box { max-width: 800px; margin: auto; padding: 40px; border: 1px solid #eee; background: white; }
        .invoice-header { display: flex; justify-content: space-between; border-bottom: 2px solid #eee; padding-bottom: 20px; margin-bottom: 20px; }
        .print-btn { background: #333; color: white; padding: 10px 20px; border: none; cursor: pointer; border-radius: 5px; }
        @media print { .print-btn, .back-btn { display: none; } body { background: white; } .container { box-shadow: none; border: none; } }
    </style>
</head>
<body>
<div class="container invoice-box">
    <div class="invoice-header">
        <div>
            <h1>INVOICE</h1>
            <p><strong>Vendor:</strong> <?php echo htmlspecialchars($order['business_name']); ?></p>
        </div>
        <div style="text-align: right;">
            <p><strong>Order ID:</strong> #<?php echo $order['id']; ?></p>
            <p><strong>Date:</strong> <?php echo date("d M Y", strtotime($order['created_at'])); ?></p>
            <p><strong>Status:</strong> <?php echo strtoupper($order['status']); ?></p>
        </div>
    </div>

    <h3>Bill To:</h3>
    <p><?php echo htmlspecialchars($order['customer']); ?><br>Email: <?php echo htmlspecialchars($order['email']); ?></p>

    <table border="1" cellpadding="10" cellspacing="0" width="100%">
        <tr style="background: #f8f9fa;">
            <th>Service Description</th>
            <th style="text-align: right;">Price</th>
        </tr>
        <tr>
            <td><?php echo htmlspecialchars($order['service_name']); ?></td>
            <td style="text-align: right;">৳<?php echo number_format($order['unit_price'], 2); ?></td>
        </tr>
        <tr>
            <td style="text-align: right;"><strong>TOTAL</strong></td>
            <td style="text-align: right;"><strong>৳<?php echo number_format($order['price'], 2); ?></strong></td>
        </tr>
    </table>

    <br><br>
    <button onclick="window.print()" class="print-btn">🖨 Print Invoice</button>
    <a href="bookings.php" class="btn back-btn" style="background: #6c757d;">⬅ Back</a>
</div>
</body>
</html>