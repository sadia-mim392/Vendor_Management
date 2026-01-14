<?php
include '../controllers/admin_controller.php';
$vendors = allVendors();
$msg = $_GET['message'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Manage Vendors</title>
  <link rel="stylesheet" href="../public/styles/admin_tables.css">
</head>

<body>

  <?php include __DIR__ . "/layouts/admin_sidebar.php"; ?>

  <main class="user-table">
    <h1>Manage Vendors</h1>

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
            <th>Vendor Name</th>
            <th>Email</th>
            <th>Business Name</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>

        <tbody>
          <?php
          if ($vendors) {
            foreach ($vendors as $vendor) {
              echo "<tr>";
              echo "<td>{$vendor['id']}</td>";
              echo "<td>{$vendor['name']}</td>";
              echo "<td>{$vendor['email']}</td>";
              echo "<td>{$vendor['business_name']}</td>";
              echo "<td>{$vendor['approved']}</td>";

              if ($vendor['approved'] === 'no') {
                echo "<td>
                      <a class='update-btn'
                         href='../controllers/admin_controller.php?vendor_approve=true&id={$vendor['id']}'>
                         Approve
                      </a>
                    </td>";
              } else {
                echo "<td>-</td>";
              }

              echo "</tr>";
            }
          } else {
            echo "<tr><td colspan='6'>No vendors found.</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </main>

</body>

</html>