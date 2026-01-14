<?php
include '../controllers/admin_controller.php';
$orders = allOrders();
$msg = $_GET['message'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Manage Orders</title>
  <link rel="stylesheet" href="../public/styles/admin_tables.css">
</head>

<body>

  <?php include __DIR__ . "/layouts/admin_sidebar.php"; ?>

  <main class="user-table">
    <h1>Manage Orders</h1>

    <?php
    if ($msg) {
      echo "<p class='msg'>" . htmlspecialchars($msg) . "</p>";
      echo "<script>history.replaceState(null, '', location.pathname);</script>";
    }
    ?>

    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>Order ID</th>
            <th>Customer</th>
            <th>Email</th>
            <th>Total Amount</th>
            <th>Status</th>
            <th>Date</th>
          </tr>
        </thead>

        <tbody>
          <?php
          if ($orders) {
            foreach ($orders as $order) {
              echo "<tr>";
              echo "<td>{$order['id']}</td>";
              echo "<td>{$order['customer_name']}</td>";
              echo "<td>{$order['customer_email']}</td>";
              echo "<td>{$order['total_amount']}</td>";
              echo "<td>{$order['status']}</td>";
              echo "<td>{$order['created_at']}</td>";
              echo "</tr>";
            }
          } else {
            echo "<tr><td colspan='6'>No orders found.</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </main>

</body>

</html>