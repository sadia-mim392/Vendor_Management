<?php
session_start();
include '../models/auth_model.php';

$_SESSION['nameErr'] = $_SESSION['emailErr'] = $_SESSION['passErr'] = "";

if ($_SERVER["REQUEST_METHOD"] == "POST"  && isset($_POST["sign-up"])) {
  $name = trim($_POST['name']);
  $email = trim($_POST['email']);
  $password = trim($_POST['password']);
  $role=$_POST["role"];

  $valid = true;

  if (empty($name)) {
    $_SESSION['nameErr'] = "Name is required.";
    $valid = false;
  } elseif (!preg_match("/^[a-zA-Z.\s]+$/", $name)) {
    $_SESSION['nameErr'] = "Only letters, spaces, and dots are allowed.";
    $valid = false;
  }

  if (empty($email)) {
    $_SESSION['emailErr'] = "Email is required.";
    $valid = false;
  } elseif (!preg_match("/^[\w\-\.]+@([\w-]+\.)+[\w-]{2,4}$/", $email)) {
    $_SESSION['emailErr'] = "Invalid email format.";
    $valid = false;
  }

  if (empty($password)) {
    $_SESSION['passErr'] = "Password is required.";
    $valid = false;
  } elseif (strlen($password) < 6) {
    $_SESSION['passErr'] = "Password must be at least 6 characters.";
    $valid = false;
  }
  if ($valid) {
    Register($name, $email, $password, $role);
  } else {
    header('Location: ../views/register.php');
  }
}
?>