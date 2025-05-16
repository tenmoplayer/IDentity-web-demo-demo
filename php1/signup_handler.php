<?php
session_start();

$conn = new mysqli("localhost", "root", "", "auth_logs");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['signup'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $role = 'user'; // default role

    if (empty($username) || empty($email) || empty($password)) {
        $_SESSION['error'] = "All fields are required.";
        header("Location: ../index.php?signup=1");
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $hashed_password, $role);

    if ($stmt->execute()) {
        $user_id = $conn->insert_id;

        $log_stmt = $conn->prepare("INSERT INTO signup (user_id) VALUES (?)");
        $log_stmt->bind_param("i", $user_id);
        $log_stmt->execute();

        header("Location: ../Untitled-1.html");
        exit();
    } else {
        $_SESSION['error'] = "Sign-up failed. Please try again.";
        header("Location: ../index.php?signup=1");
        exit();
    }
}
?>
