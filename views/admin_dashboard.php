<?php
include '../controllers/admin_controller.php';
$data=dashboardData();
// // var_dump($usersNumber);
// $eventsNumber=totalEvents();
// $bookingsNumber=totalBookings();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="../public/styles/admin_dashboard.css">
</head>

<body>
  <?php
  include __DIR__ . "/layouts/admin_sidebar.php";
  ?>
  <main class="dashboard">
    <h1>Admin Dashboard</h1>
    <p class="subtitle">System Overview</p>

    <div class="dashboard-cards">

      <div class="card">
        <span>Total Users</span>
        <h2><?php echo $data['users'] ?></h2>
      </div>

      <div class="card">
        <span>Total Vendors</span>
        <h2><?php echo $data['vendors'] ?></h2>
      </div>

      <div class="card">
        <span>Total Categories</span>
        <h2><?php echo $data['categories'] ?></h2>
      </div>

      <div class="card">
        <span>Total Services</span>
        <h2><?php echo $data['services'] ?></h2>
      </div>

      <div class="card">
        <span>Total Orders</span>
        <h2><?php echo $data['orders'] ?></h2>
      </div>

      <!-- <div class="card highlight">
        <span>Total Revenue</span>
        <h2>$ <?= $totalRevenue['total'] ?? 0 ?></h2>
      </div> -->

    </div>

  </main>
</body>

</html>