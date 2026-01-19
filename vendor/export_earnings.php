<?php
include '../includes/db.php';

// Security Check
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'vendor') {
    exit("Access Denied");
}

$user_id = $_SESSION['user_id'];
$v_res = $conn->query("SELECT id FROM vendors WHERE user_id = $user_id");
$vendor_id = $v_res->fetch_assoc()['id'];

// Set Headers to force download
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=earnings_report.csv');

// Create File Pointer
$output = fopen('php://output', 'w');

// Add Column Headings
fputcsv($output, array('Order ID', 'Date', 'Customer Name', 'Service', 'Price', 'Status'));

// Fetch Data
$query = "
    SELECT oi.id, o.created_at, u.name, s.title, oi.price, oi.status 
    FROM order_items oi
    JOIN orders o ON oi.order_id = o.id
    JOIN users u ON o.customer_id = u.id
    JOIN services s ON oi.service_id = s.id
    WHERE oi.vendor_id = $vendor_id
    ORDER BY o.created_at DESC";

$result = $conn->query($query);

// Loop and output data
while ($row = $result->fetch_assoc()) {
    fputcsv($output, $row);
}

fclose($output);
exit();
?>