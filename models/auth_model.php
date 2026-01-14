<?php
include '../config/db.php';
$_SESSION['success'] = "";
$_SESSION['login_failed'] = '';
$_SESSION['user'] = [];

function Login($email, $password)
{
  global $conn;
  $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $_SESSION['user'] = [
      'id' => $user['id'],
      'name' => $user['name'],
      'email' => $user['email'],
      'role' => $user['role'],
      'status' => $user['status'],
      'created_at' => $user['created_at']
    ];
    if ($_SESSION['user']['role'] == 'customer') {
      $conn->close();
      header("Location: ../../../../VendorManagement/index.php");
      exit;
    } elseif ($_SESSION['user']['role'] === 'admin') {
      $conn->close();
      header("Location: ../../../../VendorManagement/views/admin_dashboard.php");
      exit;
    }
  } else {
    $_SESSION['login_failed'] = "Invalid email or password.";
  }
  $conn->close();
  header("Location: ../../../../VendorManagement/views/login.php");
  exit;
}

// function Register($name, $email, $password, $role){
//   global $conn;
//   $check = "SELECT * FROM users WHERE email = '$email'";
//   $result = $conn->query($check);

//   if ($result->num_rows > 0) {
//     $_SESSION['emailErr'] = "Email already registered.";
//   } else {
//     $sql = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', '$role')";
//     if ($conn->query($sql) === TRUE) {
//       $_SESSION['success'] = "Registration successful.";
//     } else {
//       $_SESSION['success'] = "Error: " . $conn->error;
//     }
//   }
//   $conn->close();
//   header("Location: ../views/register.php");
//   exit;
// }

function Register($name, $email, $password, $role)
{
  global $conn;
  $check = "SELECT * FROM users WHERE email = '$email'";
  $result = $conn->query($check);

  if ($result->num_rows > 0) {
    $_SESSION['emailErr'] = "Email already registered.";
  } else {
    $sql="INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', '$role')";

    if($conn->query($sql)===TRUE) {
      $user_id = $conn->insert_id;
      if ($role=='vendor') {
        $vendorSql="INSERT INTO vendors (user_id, approved) VALUES ('$user_id', 'no')";
        $conn->query($vendorSql);
      }
      $_SESSION['success'] = "Registration successful.";
    } else {
      $_SESSION['success'] = "Error: " . $conn->error;
    }
  }
  $conn->close();
  header("Location: ../views/register.php");
  exit;
}


function Logout()
{
  session_start();
  session_unset();
  session_destroy();
  header(("Location: ../views/login.php"));
  exit;
}
