<?php
if(session_status()===PHP_SESSION_NONE){
  session_start();
}
$currentPath=$_SERVER['REQUEST_URI'];
?>
<nav class="navbar">
  <div class="logo">THRYVENX</div>
  <div class="nav-links">
    <ul>
      <li><a href="../../../VendorManagement/index.php" class="<?php echo strpos($currentPath, '/VendorManagement/index.php') !== false ? 'active' : ''; ?>">Home</a></li>
      <li><a href="about.php">About</a></li>
      <li><a href="services.php">Services</a></li>
      <li><a href="contact.php">Contact</a></li>
    </ul>
  </div>
  <div class="btn-container">
    <?php
    if(isset($_SESSION['user']) && !empty($_SESSION['user'])) {
      if($_SESSION['user']['role']==='admin'){
        echo '<a href="../../../VendorManagement/views/admin_dashboard.php" class="btn login-btn">Admin</a> ';
      }
      echo '<a href="../../../VendorManagement/controllers/logout_controller.php" class="btn login-btn">Logout</a>';
    } else {
      echo '<a href="../../../VendorManagement/views/login.php" class="btn login-btn">Login</a> ';
      echo '<a href="../../../VendorManagement/views/register.php" class="btn register-btn">Register</a>';
    }
    ?>
  </div>
</nav>