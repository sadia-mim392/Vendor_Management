<?php
session_start();
$nameErr = $_SESSION['nameErr'] ?? "";
$emailErr = $_SESSION['emailErr'] ?? "";
$passErr = $_SESSION['passErr'] ?? "";
$success = $_SESSION['success'] ?? "";

unset($_SESSION['nameErr'], $_SESSION['emailErr'], $_SESSION['passErr'], $_SESSION['success']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register | THRYVENX</title>
  <link rel="stylesheet" href="../public/styles/login.css">
  <link rel="stylesheet" href="../public/styles/style.css">
  <link rel="stylesheet" href="../public/styles/navbar.css">
  <link rel="stylesheet" href="../public/styles/footer.css">
  <link rel="stylesheet" href="../public/styles/register.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<?php include 'layouts/navbar.php'; ?>

<section class="login-page">
  <div class="login-container">

    <h1>Register</h1>
    <?php if (!empty($success)) echo "<div class='success-message'>$success</div>"; ?>
    <form class="login-form" onsubmit="validateRegisterForm()" method="POST" action="../controllers/register_controller.php">

      <div class="role-select">
        <label>
          <input type="radio" name="role" value="customer" checked>
          <span>Customer</span>
        </label>

        <label>
          <input type="radio" name="role" value="vendor" checked>
          <span>Vendor</span>
        </label>
      </div>

      <div class="form-group">
        <label>Name</label>
        <input type="text" placeholder="Enter Your Name" id="name" name="name" required>
        <?php if (!empty($nameErr)) echo "<small style='color:red;'>$nameErr</small>";?>
        <span class="error" id="nameError"></span>
      </div>

      <div class="form-group">
        <label>Email</label>
        <input type="email" placeholder="example@example.com" id="email" name="email" required>
        <?php if (!empty($emailErr)) echo "<small style='color:red;'>$emailErr</small>";?>
        <span class="error" id="emailError"></span>
      </div>

      <div class="form-group">
        <label>Password</label>
        <input type="password" placeholder="" id="password" name="password" required>
        <?php if (!empty($passErr)) echo "<small style='color:red;'>$passErr</small>";?>
        <span class="error" id="passwordError"></span>
      </div>

      <button type="submit" class="login-Btn" name="sign-up">Signup</button>

      <p class="register-text">
        Already have an account?
        <a href="../../VendorManagement/views/login.php">Login</a>
      </p>

    </form>

  </div>
</section>
<?php include 'layouts/footer.php'; ?>
<script src="../public/scripts/js-validation.js"></script>
</body>
</html>
