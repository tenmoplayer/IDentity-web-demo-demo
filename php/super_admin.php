<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'super_admin') {
    header('Location: index.php');
    exit;
}

include(__DIR__ . '/db.php');

$sql = "SELECT * FROM admins";
$result = $conn->query($sql);

$appointment_sql = "SELECT * FROM appointments";
$appointments_result = $conn->query($appointment_sql);

$customer_sql = "SELECT * FROM customers";  // Assuming you have a 'customers' table
$customers_result = $conn->query($customer_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Super Admin Dashboard</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      display: flex;
      min-height: 100vh;
      background-color:rgb(255, 255, 255);
      color: #333;
    }

    .sidebar {
      width: 400px;
      background-color: #2f9e4d;
      background: linear-gradient(130deg, rgba(28, 203, 140, 1) 0%, rgb(17, 17, 17) 25%);
      color: white;
      flex-shrink: 0;
    }

    .sidebar h2 {
      margin-bottom: 30px;
      font-size: 43px;
      text-align: center;
    }

    .sidebar a {
      display: block;
      font-size: 25px;
      color: white;
      text-decoration: none;
      padding: 23px 40px;
      margin-bottom: 10px;
      border-radius: 5px;
      position: relative;
      transition: background 0.3s ease;
    }

    .sidebar a::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 0;
      height: 3px;
      background-color: white;
      transition: width 0.3s ease;
    }

    .sidebar a:hover::after {
      width: 100%;
    }

    .main-content {
      flex-grow: 1;
      padding: 40px;
    }

    .dashboard-container {
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
      margin-bottom: 50px;
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
      background-color:rgb(0, 0, 0);
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

    .hidden {
      display: none;
    }
  </style>
</head>
<body>

<div class="sidebar">
  <img src="assets/logo2.png" alt="InnovaTech Logo" style="width: 300px; height: 160px; display: block; margin: 0 auto 10px;">
  <a href="#dashboard" onclick="showTab('dashboard')">📊 Dashboard</a>
  <a href="#appointment" onclick="showTab('appointments')">📅 Appointments</a>
  <a href="#customers" onclick="showTab('customers')">👥 Customers</a>
  <a href="#admins" onclick="showTab('admins')">🛠 Admins</a>
  <a href="#payments" onclick="showTab('payments')">💳 Payment Transactions</a>
  <a href="#reports" onclick="showTab('reports')">📁 Reports</a>
  <a href="logout.php">🚪 Logout</a>
</div>

<div class="main-content">
  <div id="dashboard" class="dashboard-container">
    <h1>Welcome Super Admin 👑</h1>
    <p>You are now logged in to the super admin dashboard.</p>

    <h2>Admins List</h2>
    <table>
      <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Role</th>
        <th>Actions</th>
      </tr>
      <?php
      if ($result && $result->num_rows > 0) {
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

  <div id="appointments" class="dashboard-container hidden">
    <h2>Appointments</h2>
    <table>
      <tr>
        <th>ID</th>
        <th>Customer Name</th>
        <th>Service</th>
        <th>Date</th>
        <th>Status</th>
      </tr>
      <?php
      if ($appointments_result && $appointments_result->num_rows > 0) {
          while ($row = $appointments_result->fetch_assoc()) {
              echo "<tr>
                      <td>{$row['id']}</td>
                      <td>{$row['customer_name']}</td>
                      <td>{$row['service']}</td>
                      <td>{$row['appointment_date']}</td>
                      <td>{$row['status']}</td>
                    </tr>";
          }
      } else {
          echo "<tr><td colspan='5'>No appointments found</td></tr>";
      }
      ?>
    </table>
  </div>

  <div id="customers" class="dashboard-container hidden">
    <h2>Customers</h2>
    <table>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
      </tr>
      <?php
      if ($customers_result && $customers_result->num_rows > 0) {
          while ($row = $customers_result->fetch_assoc()) {
              echo "<tr>
                      <td>{$row['id']}</td>
                      <td>{$row['name']}</td>
                      <td>{$row['email']}</td>
                      <td>{$row['phone']}</td>
                    </tr>";
          }
      } else {
          echo "<tr><td colspan='4'>No customers found</td></tr>";
      }
      ?>
    </table>
  </div>

  <div id="admins" class="dashboard-container hidden">
    <!-- Add content for admins tab here -->
  </div>

  <div id="payments" class="dashboard-container hidden">
    <!-- Add content for payments tab here -->
  </div>

  <div id="reports" class="dashboard-container hidden">
    <!-- Add content for reports tab here -->
  </div>
</div>

<script>
function showTab(tabName) {
    const tabs = document.querySelectorAll('.dashboard-container');
    tabs.forEach(tab => {
        tab.classList.add('hidden');
    });
    const activeTab = document.getElementById(tabName);
    if (activeTab) {
        activeTab.classList.remove('hidden');
    }
}
</script>

</body>
</html>
