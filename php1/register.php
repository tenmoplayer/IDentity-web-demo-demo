<?php
session_start();
require_once 'db.php'; // Database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST["action"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    if ($action === "signup" && !empty($email) && !empty($password)) {
        $hashed_password = hash("sha256", $password);
        $role = 'user'; // Default role

        $query = "INSERT INTO users (email, password_hash, role) VALUES (?, ?, ?)";

        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param("sss", $email, $hashed_password, $role);
            if ($stmt->execute()) {
                $_SESSION["message"] = "Account created successfully! Please log in.";
                header("Location: index.php");
                exit();
            } else {
                $_SESSION["error"] = "Registration failed!";
            }
            $stmt->close();
        }
    }
}
?>