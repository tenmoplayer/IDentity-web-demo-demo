<?php
// Include database connection
include(__DIR__ . '/db.php');

// Start session for user authentication
session_start();

// Check if the user is logged in and if they have the correct role (Super Admin or Admin)
if (!isset($_SESSION['username']) || ($_SESSION['role'] !== 'super_admin' && $_SESSION['role'] !== 'admin')) {
    header("Location: login.php");  // Redirect to login if not logged in or no proper role
    exit();
}

// Fetch users and admins from the database
$sql = "SELECT * FROM users";  // Assuming you have a table called 'users' for both regular users and admins
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Users and Admins</title>
    <link rel="stylesheet" href="style.css">  <!-- Include your custom CSS for styling -->
</head>
<body>
    <h1>Users and Admins List</h1>
    
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>

        <?php
        if ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['username'] . "</td>";
                echo "<td>" . $row['role'] . "</td>";
                echo "<td><a href='edit_user.php?id=" . $row['id'] . "'>Edit</a> | <a href='delete_user.php?id=" . $row['id'] . "'>Delete</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No users found.</td></tr>";
        }
        ?>

    </table>

</body>
</html>