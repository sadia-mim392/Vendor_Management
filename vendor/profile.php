<?php
include '../includes/db.php';

// Security Check
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'vendor') {
    header("Location: temp_login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Handle Form Submission (Update Profile)
$success_msg = "";
if (isset($_POST['update_profile'])) {
    $b_name = $_POST['business_name'];
    $loc = $_POST['location'];
    // Description is missing in your SQL file, but good to handle if added later. 
    // We will update Business Name and Location.
    
    $stmt = $conn->prepare("UPDATE vendors SET business_name = ?, location = ? WHERE user_id = ?");
    $stmt->bind_param("ssi", $b_name, $loc, $user_id);
    
    if ($stmt->execute()) {
        $success_msg = "✅ Profile Updated Successfully!";
    } else {
        $success_msg = "❌ Error updating profile.";
    }
}

// Fetch Current Data
$query = $conn->prepare("SELECT * FROM vendors WHERE user_id = ?");
$query->bind_param("i", $user_id);
$query->execute();
$vendor = $query->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        .profile-form { max-width: 600px; margin: auto; background: white; padding: 30px; border-radius: 10px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-weight: bold; margin-bottom: 5px; }
        .form-group input, .form-group textarea { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; }
        .alert { padding: 10px; background: #d4edda; color: #155724; border-radius: 5px; margin-bottom: 20px; text-align: center; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>⚙️ Business Settings</h1>
        <a href="dashboard.php" class="btn">⬅ Dashboard</a>
    </div>

    <div class="profile-form">
        <?php if($success_msg): ?>
            <div class="alert"><?php echo $success_msg; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Business Name:</label>
                <input type="text" name="business_name" value="<?php echo htmlspecialchars($vendor['business_name']); ?>" required>
            </div>

            <div class="form-group">
                <label>Location / Address:</label>
                <input type="text" name="location" value="<?php echo htmlspecialchars($vendor['location'] ?? ''); ?>" placeholder="e.g. Bashundhara R/A, Dhaka">
            </div>

            <button type="submit" name="update_profile" class="btn btn-success" style="width: 100%;">💾 Save Changes</button>
        </form>
    </div>
</div>
</body>
</html>