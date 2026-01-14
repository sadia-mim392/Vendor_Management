<?php
$currentPath = $_SERVER['REQUEST_URI'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard | THRYVENX</title>
  <link rel="stylesheet" href="../public/styles/admin_sidebar.css" />
</head>

<body>
  <div class="sidebar">
    <h2 class="sidebar-title">THRYVENX Admin</h2>
    <ul class="sidebar-menu">
      <li class="<?php echo strpos($currentPath, '/VendorManagement/views/admin_dashboard.php') !== false ? 'active' : '' ?>"><a href="../views/admin_dashboard.php">Dashboard</a></li>
      <li class="<?php echo strpos($currentPath, '/VendorManagement/views/user_management.php') !== false ? 'active' : '' ?>"><a href="../views/user_management.php">Manage Users</a></li>
      <li class="<?php echo strpos($currentPath, '/VendorManagement/views/vendor_management.php') !== false ? 'active' : '' ?>"><a href="../views/vendor_management.php">Manage Vendors</a></li>
      <li class="<?php echo strpos($currentPath, '/VendorManagement/views/category_management.php') !== false ? 'active' : '' ?>"><a href="../views/category_management.php">Manage Categories</a></li>
      <li class="<?php echo strpos($currentPath, '/VendorManagement/views/service_management.php') !== false ? 'active' : '' ?>"><a href="../views/service_management.php">Manage Services</a></li>
      <li class="<?php echo strpos($currentPath, '/VendorManagement/views/order_management.php') !== false ? 'active' : '' ?>"><a href="../views/order_management.php">Manage Orders</a></li>
      <li><a href="../../../VendorManagement/index.php">Home</a></li>
      <li><a href="../controllers/logout_controller.php">Logout</a></li>
    </ul>
  </div>
</body>

</html>