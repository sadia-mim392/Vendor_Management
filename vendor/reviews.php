<?php
include '../includes/db.php';

// Security Check
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'vendor') {
    header("Location: temp_login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$v_res = $conn->query("SELECT id FROM vendors WHERE user_id = $user_id");
$vendor_id = $v_res->fetch_assoc()['id'];

// Fetch All Reviews for this Vendor's Services
$query = "
    SELECT r.*, u.name as customer_name, s.title as service_name
    FROM reviews r
    JOIN services s ON r.service_id = s.id
    JOIN users u ON r.customer_id = u.id
    WHERE s.vendor_id = $vendor_id
    ORDER BY r.created_at DESC
";
$result = $conn->query($query);

// Calculate Average Rating
$avg_query = $conn->query("
    SELECT AVG(r.rating) as avg_rating, COUNT(*) as total 
    FROM reviews r 
    JOIN services s ON r.service_id = s.id 
    WHERE s.vendor_id = $vendor_id
");
$stats = $avg_query->fetch_assoc();
$avg_rating = round($stats['avg_rating'], 1);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Customer Reviews</title>
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        .rating-box { text-align: center; background: #fff; padding: 20px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #ddd; }
        .big-star { font-size: 40px; color: #ffc107; }
        .review-card { background: white; border: 1px solid #eee; padding: 15px; border-radius: 8px; margin-bottom: 15px; }
        .review-header { display: flex; justify-content: space-between; margin-bottom: 10px; }
        .stars { color: #ffc107; font-weight: bold; }
        .service-tag { background: #e9ecef; color: #495057; padding: 2px 8px; border-radius: 4px; font-size: 12px; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>⭐ Customer Reviews</h1>
        <a href="dashboard.php" class="btn">⬅ Dashboard</a>
    </div>

    <div class="rating-box">
        <h2>Overall Rating</h2>
        <div class="big-star">
            <?php echo $avg_rating; ?> <span style="font-size: 20px; color: #888;">/ 5</span>
        </div>
        <p>Based on <?php echo $stats['total']; ?> reviews</p>
    </div>

    <h3>Recent Feedback</h3>
    <?php if ($result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
        <div class="review-card">
            <div class="review-header">
                <div>
                    <strong><?php echo htmlspecialchars($row['customer_name']); ?></strong>
                    <span class="service-tag">for: <?php echo htmlspecialchars($row['service_name']); ?></span>
                </div>
                <div class="stars">
                    <?php echo str_repeat("⭐", $row['rating']); ?>
                </div>
            </div>
            <p style="color: #555;">"<?php echo htmlspecialchars($row['comment']); ?>"</p>
            <small style="color: #999;"><?php echo date("d M Y", strtotime($row['created_at'])); ?></small>
        </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p style="text-align: center; color: #666;">No reviews yet. Deliver great service to get some!</p>
    <?php endif; ?>
</div>
</body>
</html>