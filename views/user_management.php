<?php
include '../controllers/admin_controller.php';
$users = allUsers();
$msg = $_GET['message'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Manage Users</title>
  <link rel="stylesheet" href="../public/styles/admin_tables.css">
</head>

<body>

  <?php include __DIR__ . "/layouts/admin_sidebar.php"; ?>

  <main class="user-table">
    <h1>Manage Users</h1>

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
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Action</th>
          </tr>
        </thead>

        <tbody>
          <?php
          if ($users) {
            foreach ($users as $user) {
              echo "<tr>";
              echo "<td>{$user['id']}</td>";
              echo "<td>{$user['name']}</td>";
              echo "<td>{$user['email']}</td>";
              echo "<td>{$user['role']}</td>";

              if ($user['role'] !== 'admin') {
                echo "<td>
                      <a class='delete-btn'
                         onclick=\"return confirm('Are you sure you want to delete this user?')\"
                         href='../controllers/admin_controller.php?user_delete=true&id={$user['id']}'>
                         Delete
                      </a>
                    </td>";
              } else {
                echo "<td>-</td>";
              }

              echo "</tr>";
            }
          } else {
            echo "<tr><td colspan='5'>No users found.</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </main>

</body>

</html>