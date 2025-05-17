<?php
session_start();

// Database connection
$conn = new mysqli("localhost", "root", "", "auth_logs"); // Update with your credentials
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['signup'])) {
    $name = $_POST['name'];
    $username = $_POST['username']; 
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hash = password_hash($password, PASSWORD_BCRYPT);
    $role = 'user';

    // Insert into users table
    $stmt = $conn->prepare("INSERT INTO users (full_name, username, email, password, role) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $username, $email, $hash, $role);

    if ($stmt->execute()) {
        // Log sign-up event
        $new_user_id = $conn->insert_id;
        $log_stmt = $conn->prepare("INSERT INTO signup (user_id) VALUES (?)");
        $log_stmt->bind_param("i", $new_user_id);
        $log_stmt->execute();

        header("Location: /ils-expo/Untitled-1.html");
        exit();
    } else {
        $_SESSION['error'] = "Sign-up failed.";
        header("Location: index.php?signup=1");
        exit();
    }
}
?>
