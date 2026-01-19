<?php
include '../includes/db.php';
$user_id = $_SESSION['user_id'];

// Get Vendor ID
$v_res = $conn->query("SELECT id FROM vendors WHERE user_id = $user_id");
$vendor_id = $v_res->fetch_assoc()['id'];

// Handle Adding Service
if (isset($_POST['add'])) {
    $title = $_POST['title'];
    $price = $_POST['price'];
    $cat = $_POST['cat'];
    
    $stmt = $conn->prepare("INSERT INTO services (vendor_id, category_id, title, price, status) VALUES (?, ?, ?, ?, 'active')");
    $stmt->bind_param("iisd", $vendor_id, $cat, $title, $price);
    $stmt->execute();
    header("Location: manage_services.php"); // Refresh to clear form
    exit();
}

// Handle Status Toggle (Available / Unavailable)
if (isset($_GET['toggle']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $current = $_GET['toggle'];
    $new_status = ($current == 'active') ? 'inactive' : 'active';
    
    $conn->query("UPDATE services SET status='$new_status' WHERE id=$id AND vendor_id=$vendor_id");
    header("Location: manage_services.php");
    exit();
}

// Get Services
$services = $conn->query("SELECT s.*, c.name as cat_name FROM services s JOIN categories c ON s.category_id = c.id WHERE vendor_id = $vendor_id");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Services</title>
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        .badge-active { background: #d4edda; color: #155724; padding: 5px 10px; border-radius: 15px; font-size: 12px; font-weight: bold; }
        .badge-inactive { background: #f8d7da; color: #721c24; padding: 5px 10px; border-radius: 15px; font-size: 12px; font-weight: bold; }
        .toggle-btn { font-size: 12px; text-decoration: none; margin-left: 10px; border: 1px solid #ccc; padding: 2px 8px; border-radius: 4px; background: white; }
        .toggle-btn:hover { background: #eee; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>📦 Manage My Products</h1>
        <a href="dashboard.php" class="btn">⬅ Dashboard</a>
    </div>

    <form method="POST">
        <h3>➕ Add New Product</h3>
        <div style="display: flex; gap: 10px; align-items: center;">
            <input type="text" name="title" placeholder="Product Name (e.g. Luxury Chair)" required>
            <input type="number" name="price" placeholder="Price" required>
            <select name="cat">
                <option value="1">Wedding Decoration</option>
                <option value="2">Catering</option>
                <option value="3">Lighting</option>
                <option value="4">Photography</option>
            </select>
            <button type="submit" name="add" class="btn btn-success" style="margin: 0;">Add Now</button>
        </div>
    </form>

    <h3>📜 Current Inventory</h3>
    <table>
        <tr>
            <th>Product Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Availability</th> <th>Action</th>
        </tr>
        <?php while($s = $services->fetch_assoc()): ?>
        <tr style="opacity: <?php echo ($s['status'] == 'inactive') ? '0.6' : '1'; ?>;">
            <td><?php echo htmlspecialchars($s['title']); ?></td>
            <td><?php echo htmlspecialchars($s['cat_name']); ?></td>
            <td>৳<?php echo number_format($s['price'], 2); ?></td>
            
            <td>
                <?php if($s['status'] == 'active'): ?>
                    <span class="badge-active">✅ Available</span>
                <?php else: ?>
                    <span class="badge-inactive">⛔ Unavailable</span>
                <?php endif; ?>
            </td>

            <td>
                <a href="?toggle=<?php echo $s['status']; ?>&id=<?php echo $s['id']; ?>" class="toggle-btn">
                    🔄 Change Status
                </a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>
</body>
</html>