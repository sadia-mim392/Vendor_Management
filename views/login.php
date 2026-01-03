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
    <form class="login-form" method="POST" action="">

      <div class="form-group">
        <label>Email</label>
        <input type="email" placeholder="example@example.com" required>
      </div>

      <div class="form-group">
        <label>Password</label>
        <div class="password-field">
          <input type="password" placeholder="" required>
        </div>

        <div class="form-meta">
          <small>Must be 6 Characters at Least</small>
        </div>
      </div>

      <button type="submit" class="login-Btn">Sign in</button>

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