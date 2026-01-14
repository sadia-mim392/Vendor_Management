<?php
include '../controllers/admin_controller.php';
$services = allServices();
$msg = $_GET['message'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Services</title>
  <link rel="stylesheet" href="../public/styles/admin_tables.css">
</head>
<body>

<?php include __DIR__ . "/layouts/admin_sidebar.php"; ?>

<main class="user-table">
  <h1>Manage Services</h1>

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
          <th>ID</th>
          <th>Service Title</th>
          <th>Vendor</th>
          <th>Category</th>
          <th>Price</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>

      <tbody>
        <?php
        if ($services) {
          foreach ($services as $service) {
            echo "<tr>";
            echo "<td>{$service['id']}</td>";
            echo "<td>{$service['title']}</td>";
            echo "<td>{$service['vendor_name']}</td>";
            echo "<td>{$service['category_name']}</td>";
            echo "<td>{$service['price']}</td>";
            echo "<td>{$service['status']}</td>";

            echo "<td>
                    <a class='update-btn'
                       href='../controllers/admin_controller.php?service_toggle=true&id={$service['id']}&status={$service['status']}'>
                       Toggle
                    </a>
                  </td>";

            echo "</tr>";
          }
        } else {
          echo "<tr><td colspan='7'>No services found.</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
</main>

</body>
</html>
