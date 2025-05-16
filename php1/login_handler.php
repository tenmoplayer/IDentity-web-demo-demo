<?php
session_start();

// DB connections
$conn = new mysqli("localhost", "root", "", "auth_logs");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn2 = new mysqli("localhost", "root", "", "user_management");
if ($conn2->connect_error) {
    die("Second DB connection failed: " . $conn2->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_input = trim($_POST['user_input']);
    $password = $_POST['password'];

    if (empty($user_input) || empty($password)) {
        $_SESSION['error'] = "Please fill in all fields.";
        header("Location: ../index.php");
        exit();
    }

    $stmt = $conn->prepare("SELECT id, username, email, password, role FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $user_input, $user_input);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($user = $res->fetch_assoc()) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Log the sign-in
            $log_stmt = $conn->prepare("INSERT INTO signin (user_id) VALUES (?)");
            $log_stmt->bind_param("i", $user['id']);
            $log_stmt->execute();

            // Redirect based on role
            switch ($user['role']) {
                case 'super_admin':
                    header("Location: ../super_admin.php");
                    break;
                case 'admin':
                    header("Location: ../php/admin.php");
                    break;
                default:
                    header("Location: ../Untitled-1.html");
                    break;
            }
            exit();
        } else {
            $_SESSION['error'] = "Incorrect password.";
            header("Location: ../index.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "User not found.";
        header("Location: ../index.php");
        exit();
    }
}
?>
