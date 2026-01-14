<?php
include '../controllers/admin_controller.php';
$categories = allCategories();
$msg = $_GET['message'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Manage Categories</title>
  <link rel="stylesheet" href="../public/styles/admin_tables.css">
</head>

<body>

  <?php include __DIR__ . "/layouts/admin_sidebar.php"; ?>

  <main class="user-table">
    <h1>Manage Categories</h1>

    <?php
    if ($msg) {
      echo "<p class='msg'>" . htmlspecialchars($msg) . "</p>";
      echo "<script>history.replaceState(null, '', location.pathname);</script>";
    }
    ?>

    <form method="POST" class="btn-container">
      <input type="text" name="category_name" placeholder="Enter category name" required>
      <button type="submit" name="add_category" class="update-btn">Add</button>
    </form>

    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Category Name</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>

        <tbody>
          <?php
          if ($categories) {
            foreach ($categories as $cat) {
              echo "<tr>";
              echo "<td>{$cat['id']}</td>";
              echo "<td>{$cat['name']}</td>";
              echo "<td>{$cat['status']}</td>";
              echo "<td>
                    <a class='delete-btn'
                       onclick=\"return confirm('Delete this category?')\"
                       href='../controllers/admin_controller.php?category_delete=true&id={$cat['id']}'>
                       Delete
                    </a>
                  </td>";
              echo "</tr>";
            }
          } else {
            echo "<tr><td colspan='4'>No categories found.</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </main>

</body>

</html>