<?php
session_start();

// Database connection
$conn = new mysqli("localhost", "root", "", "auth_logs"); // Update with your credentials
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['signin'])) {
    $user_input = $_POST['user_input']; // Can be username or email
    $password = $_POST['password'];

    // Query to check if the user exists using EITHER username OR email
    $stmt = $conn->prepare("SELECT id, username, email, password, role FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $user_input, $user_input);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($user = $res->fetch_assoc()) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Log sign-in event
            $stmt = $conn->prepare("INSERT INTO signin (user_id) VALUES (?)");
            $stmt->bind_param("i", $user['id']);
            $stmt->execute();

            // Redirect based on role
            if ($user['role'] === 'super_admin') {
                header("Location: super_admin_dashboard.php");
            } elseif ($user['role'] === 'admin') {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: user_dashboard.php");
            }
            exit();
        } else {
            $_SESSION['error'] = "Incorrect password.";
            header("Location: index.php?signin=1");
            exit();
        }
    } else {
        $_SESSION['error'] = "User not found.";
        header("Location: index.php?signin=1");
        exit();
    }
}
?>
