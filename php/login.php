<?php
session_start();
require_once 'db.php'; // Database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get input values
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate inputsAS
    if (!empty($username) && !empty($password)) {
        // Prepare and execute query to check if the user exists in any of the three tables
        $query = "SELECT id, username, password, role FROM admins WHERE username = ? 
                  UNION 
                  SELECT id, username, password, role FROM super_admin WHERE username = ?";

        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param("ss", $username, $username);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($id, $db_username, $db_password, $role);

            if ($stmt->num_rows > 0) {
                // Fetch the user data
                $stmt->fetch();
                
                // Verify password
                if (password_verify($password, $db_password)) {
                    // Set session variables
                    $_SESSION['logged_in'] = true;
                    $_SESSION['user_id'] = $id;
                    $_SESSION['username'] = $db_username;
                    $_SESSION['role'] = $role;

                    // Redirect based on role
                    if ($role == 'super_admin') {
                        header("Location: super_admin.php");
                    } elseif ($role == 'admin') {
                        header("Location: admin.php");
                    } 
                    exit();
                } else {
                    $error_message = "Invalid password!";
                }
            } else {
                $error_message = "No user found with that username!";
            }

            $stmt->close();
        } else {
            $error_message = "Failed to execute query!";
        }
    } else {
        $error_message = "Please enter both username and password.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>

    <h2>Login</h2>
    
    <?php if (isset($error_message)): ?>
        <div style="color: red;"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <form method="POST" action="login.php">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br>

        <button type="submit">Login</button>
    </form>

</body>
</html>
