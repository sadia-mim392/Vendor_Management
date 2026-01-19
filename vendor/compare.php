<?php
include '../includes/db.php';

// Security Check
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'vendor') {
    header("Location: temp_login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Get Vendor ID
$v_res = $conn->query("SELECT id FROM vendors WHERE user_id = $user_id");
$vendor_id = $v_res->fetch_assoc()['id'];

// Fetch all services for the dropdowns
$services = $conn->query("SELECT id, title FROM services WHERE vendor_id = $vendor_id");
$all_services = [];
while ($row = $services->fetch_assoc()) {
    $all_services[] = $row;
}

// Handle Comparison Logic
$s1 = null;
$s2 = null;

if (isset($_POST['compare'])) {
    $id1 = intval($_POST['service1']);
    $id2 = intval($_POST['service2']);

    if ($id1 && $id2) {
        // Fetch Service 1
        $q1 = $conn->query("SELECT s.*, c.name as cat_name FROM services s JOIN categories c ON s.category_id = c.id WHERE s.id = $id1 AND s.vendor_id = $vendor_id");
        $s1 = $q1->fetch_assoc();

        // Fetch Service 2
        $q2 = $conn->query("SELECT s.*, c.name as cat_name FROM services s JOIN categories c ON s.category_id = c.id WHERE s.id = $id2 AND s.vendor_id = $vendor_id");
        $s2 = $q2->fetch_assoc();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Compare Services</title>
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        .compare-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 30px; }
        .compare-card { background: white; padding: 20px; border-radius: 10px; border: 1px solid #ddd; text-align: center; }
        .vs-badge { background: #333; color: white; padding: 10px; border-radius: 50%; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; margin: 20px auto; font-weight: bold; }
        .price-tag { font-size: 24px; color: #28a745; font-weight: bold; margin: 10px 0; }
        select { width: 100%; padding: 10px; margin-bottom: 10px; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>⚖️ Compare My Packages</h1>
        <a href="dashboard.php" class="btn">⬅ Dashboard</a>
    </div>

    <form method="POST" style="background: #e9ecef;">
        <div style="display: flex; gap: 20px;">
            <div style="flex: 1;">
                <label>Select Service A:</label>
                <select name="service1" required>
                    <option value="">-- Choose Service --</option>
                    <?php foreach ($all_services as $s): ?>
                        <option value="<?php echo $s['id']; ?>" <?php if(isset($_POST['service1']) && $_POST['service1'] == $s['id']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($s['title']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div style="flex: 1;">
                <label>Select Service B:</label>
                <select name="service2" required>
                    <option value="">-- Choose Service --</option>
                    <?php foreach ($all_services as $s): ?>
                        <option value="<?php echo $s['id']; ?>" <?php if(isset($_POST['service2']) && $_POST['service2'] == $s['id']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($s['title']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <button type="submit" name="compare" class="btn" style="width: 100%; margin-top: 10px;">🔍 Compare Now</button>
    </form>

    <?php if ($s1 && $s2): ?>
    <div class="compare-grid">
        <div class="compare-card">
            <h3><?php echo htmlspecialchars($s1['title']); ?></h3>
            <p class="price-tag">৳<?php echo number_format($s1['price'], 2); ?></p>
            <p><strong>Category:</strong> <?php echo $s1['cat_name']; ?></p>
            <p><strong>Status:</strong> <span class="badge badge-accepted">Active</span></p>
            <hr>
            <p style="color: #666;">This is your baseline service.</p>
        </div>

        <div class="compare-card" style="border-color: #007bff; box-shadow: 0 0 10px rgba(0,123,255,0.1);">
            <h3><?php echo htmlspecialchars($s2['title']); ?></h3>
            <p class="price-tag">৳<?php echo number_format($s2['price'], 2); ?></p>
            <p><strong>Category:</strong> <?php echo $s2['cat_name']; ?></p>
            <p><strong>Status:</strong> <span class="badge badge-accepted">Active</span></p>
            <hr>
            <?php 
                $diff = $s2['price'] - $s1['price'];
                if($diff > 0) echo "<p style='color: green;'>+৳".number_format($diff, 2)." more expensive</p>";
elseif($diff < 0) echo "<p style='color: red;'>-৳".number_format(abs($diff), 2)." cheaper</p>";
                else echo "<p style='color: blue;'>Same Price</p>";
            ?>
        </div>
    </div>
    <?php endif; ?>

</div>
</body>
</html>