<?php
include '../config/db.php';

function getAllUsers()
{
  global $conn;
  $sql = "select * from users where role != 'admin'";

  $result = $conn->query($sql);
  $users = [];
  while ($row = $result->fetch_assoc()) {
    $users[] = $row;
  }
  return $users;
}

function getAllCategories()
{
  global $conn;
  $sql = "select * from categories";
  $result = $conn->query($sql);
  $categories = [];
  while ($row = $result->fetch_assoc()) {
    $categories[] = $row;
  }
  return $categories;
}

function addCategory($name)
{
  global $conn;
  $sql = "insert INTO categories (name, status) VALUES ('$name', 'active')";
  return $conn->query($sql);
}

function deleteCategory($id)
{
  global $conn;
  $sql = "delete FROM categories WHERE id = '$id'";
  return $conn->query($sql);
}

function getAllOrders()
{
  global $conn;
  
  $sql="select orders.id,orders.total_amount,orders.status,orders.created_at,users.name AS customer_name,users.email AS customer_email from orders join users ON orders.customer_id = users.id ORDER BY orders.created_at desc";
  $result = $conn->query($sql);
  $orders = [];
  while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
  }
  return $orders;
}

function getAllServices()
{
  global $conn;
  $sql = "select services.id,services.title,services.price,services.status,categories.name as category_name,users.name AS vendor_name from services join categories on services.category_id = categories.id join vendors on services.vendor_id = vendors.id join users on vendors.user_id = users.id";;
  $result = $conn->query($sql);
  $services = [];
  while ($row = $result->fetch_assoc()) {
    $services[] = $row;
  }
  return $services;
}

function toggleServiceStatus($id, $status)
{
  global $conn;
  $newStatus = ($status === 'active') ? 'inactive' : 'active';
  $sql = "update services SET status='$newStatus' where id='$id'";
  return $conn->query($sql);
}


function deleteUser($id)
{
  global $conn;
  $sql = "delete from users where id='$id'";
  $result = $conn->query($sql);
  return $result;
}

function getAllVendors()
{
  global $conn;
  $sql = "select vendors.id,users.name,users.email,vendors.business_name,vendors.approved FROM vendors join users ON vendors.user_id = users.id";

  $vendors = [];
  $result = $conn->query($sql);
  while ($row = $result->fetch_assoc()) {
    $vendors[] = $row;
  }
  return $vendors;
}

function approveVendor($vendorId)
{
  global $conn;
  $sql = "update vendors SET approved='yes' WHERE id='$vendorId'";
  return $conn->query($sql);
}

?>