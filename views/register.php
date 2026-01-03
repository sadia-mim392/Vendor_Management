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
    <form class="login-form" method="POST" action="index.php?page=register">

      <div class="role-select">
        <label>
          <input type="radio" name="role" value="provider">
          <span>Provider</span>
        </label>

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
        <label>First Name</label>
        <input type="text" placeholder="Enter First Name" required>
      </div>

      <div class="form-group">
        <label>Last Name</label>
        <input type="text" placeholder="Enter Last Name" required>
      </div>

      <div class="form-group">
        <label>Email</label>
        <input type="email" placeholder="example@example.com" required>
      </div>

      <div class="form-group">
        <label>Password</label>
        <div class="password-field">
          <input type="password" placeholder="" required>
        </div>
      </div>

      <button type="submit" class="login-Btn">Signup</button>

      <p class="register-text">
        Already have an account?
        <a href="../../VendorManagement/views/login.php">Login</a>
      </p>

    </form>

  </div>
</section>
<?php include 'layouts/footer.php'; ?>

</body>
</html>
