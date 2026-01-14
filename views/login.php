<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login | THRYVENX</title>
  <link rel="stylesheet" href="../public/styles/style.css">
  <link rel="stylesheet" href="../public/styles/navbar.css">
  <link rel="stylesheet" href="../public/styles/login.css">
  <link rel="stylesheet" href="../public/styles/footer.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<?php include 'layouts/navbar.php'; ?>

<section class="login-page">
  <div class="login-container">

    <h1>Login</h1>
    <?php
    if (!empty($_SESSION['login_failed'])) {
      echo '<p class="error-msg">' . $_SESSION['login_failed'] . '</p>';
      $_SESSION['login_failed'] = '';
    }
    ?>
    <form class="login-form" method="POST" action="../controllers/login_controller.php">

      <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" placeholder="example@example.com" required>
      </div>

      <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" placeholder="" required>
      </div>

      <button type="submit" class="login-Btn" name="sign-in">Sign in</button>

      <p class="register-text">
        Don't have an account ?
        <a href="../views/register.php">Register</a>
      </p>

    </form>

  </div>
</section>
<?php include 'layouts/footer.php'; ?>
</body>
</html>