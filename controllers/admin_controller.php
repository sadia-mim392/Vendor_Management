<?php
include '../models/admin_model.php';

function allUsers(){
  return getAllUsers();
}

function dashboardData(){
  $users=getAllUsers();
  $vendors=[];
  foreach($users as $user){
    if($user['role']=='vendor'){
      array_push($vendors,$user);
    }
  }
  $categories=getAllCategories();
  $services=getAllServices();
  $orders=getAllOrders();
  return ['users' => count($users),'vendors' => count($vendors),'categories'=>count($categories), 'services' => count($services), 'orders'=>count($orders)];
}

if(isset($_GET['user_delete'])){
  $id=$_GET['id'];
  $result=deleteUser($id);
  $msg=$result?"User deleted successfully":"Failed to delete user";
  header("Location: ../views/user_management.php?message='$msg'");
}

function allVendors() {
  return getAllVendors();
}


if (isset($_GET['vendor_approve']) && isset($_GET['id'])) {
  $vendorId = $_GET['id'];
  $result=approveVendor($vendorId);

  if ($result) {
    header("Location: ../views/vendor_management.php?message=Vendor approved successfully");
  } else {
    header("Location: ../views/vendor_management.php?message=Failed to approve vendor");
  }
  exit;
}

function allCategories() {
  return getAllCategories();
}


if (isset($_POST['add_category'])) {
  $name = trim($_POST['category_name']);
  if ($name !== '') {
    addCategory($name);
    header("Location: ../views/category_management.php?message=Category added successfully");
  } else {
    header("Location: ../views/category_management.php?message=Category name required");
  }
  exit;
}

if (isset($_GET['category_delete']) && isset($_GET['id'])) {
  deleteCategory($_GET['id']);
  header("Location: ../views/category_management.php?message=Category deleted successfully");
  exit;
}

function allServices() {
  return getAllServices();
}


if (isset($_GET['service_toggle']) && isset($_GET['id']) && isset($_GET['status'])) {
  toggleServiceStatus($_GET['id'], $_GET['status']);
  header("Location: ../views/service_management.php?message=Service status updated");
  exit;
}

function allOrders() {
  return getAllOrders();
}

?>