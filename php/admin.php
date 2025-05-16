<?php
session_start();

// Check if the user is logged in and has the admin role
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit;
}

include(__DIR__ . '/db.php');

// Fetch all users from the admins table
$sql = "SELECT * FROM admins";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      background-color: #f4f6f9;
      color: #333;
      padding: 40px;
    }

    .dashboard-container {
      max-width: 1000px;
      margin: 0 auto;
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    h1 {
      font-size: 28px;
      margin-bottom: 10px;
      color: #2c3e50;
    }

    p {
      font-size: 16px;
      margin-bottom: 25px;
      color: #555;
    }

    a.button {
      display: inline-block;
      background-color: #3498db;
      color: #fff;
      text-decoration: none;
      padding: 10px 20px;
      border-radius: 6px;
      font-weight: bold;
      transition: background-color 0.3s ease;
      margin-bottom: 20px;
    }

    a.button:hover {
      background-color: #2980b9;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }

    th, td {
      padding: 12px 15px;
      border-bottom: 1px solid #ddd;
      text-align: left;
    }

    th {
      background-color: #3498db;
      color: white;
    }

    tr:hover {
      background-color: #f1f1f1;
    }

    .actions a {
      margin-right: 10px;
      color: #3498db;
      text-decoration: none;
      font-weight: 500;
    }

    .actions a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="dashboard-container">
    <h1>Welcome Admin 🔧</h1>
    <p>You are now logged in to the admin dashboard.</p>
    <a href="index.php" class="button">Logout</a>

    <h2>Users List</h2>
    <table>
      <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Role</th>
        <th>Actions</th>
      </tr>
      <?php
      if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
              echo "<tr>
                      <td>{$row['id']}</td>
                      <td>{$row['username']}</td>
                      <td>{$row['role']}</td>
                      <td class='actions'>
                          <a href='edit_user.php?id={$row['id']}'>Edit</a> |
                          <a href='delete_user.php?id={$row['id']}'>Delete</a>
                      </td>
                    </tr>";
          }
      } else {
          echo "<tr><td colspan='4'>No users found</td></tr>";
      }
      ?>
    </table>
  </div>
</body>
</html>
