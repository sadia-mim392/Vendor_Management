<?php
include '../includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'vendor') {
    header("Location: temp_login.php");
    exit();
}

$msg = "";
if (isset($_POST['send'])) {
    $uid = $_SESSION['user_id'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    
    $stmt = $conn->prepare("INSERT INTO contact_messages (user_id, subject, message) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $uid, $subject, $message);
    if ($stmt->execute()) {
        $msg = "✅ Message sent to Admin successfully!";
    } else {
        $msg = "❌ Error sending message.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Contact Support</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<div class="container">
    <div class="header">
        <h1>📞 Contact Admin Support</h1>
        <a href="dashboard.php" class="btn">⬅ Dashboard</a>
    </div>

    <?php if($msg): ?>
        <div style="background: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
            <?php echo $msg; ?>
        </div>
    <?php endif; ?>

    <form method="POST" style="background: white; padding: 0;">
        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: bold; margin-bottom: 5px;">Subject:</label>
            <input type="text" name="subject" placeholder="e.g. Issue with payment" style="width: 100%; box-sizing: border-box;" required>
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display: block; font-weight: bold; margin-bottom: 5px;">Message:</label>
            <textarea name="message" rows="5" placeholder="Describe your issue..." style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box;" required></textarea>
        </div>

        <button type="submit" name="send" class="btn btn-success">📩 Send Message</button>
    </form>
</div>
</body>
</html>