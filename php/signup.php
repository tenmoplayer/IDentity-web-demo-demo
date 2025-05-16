<?php
header('Content-Type: application/json');
require_once 'db.php'; // Assuming this file contains your database connection

// Retrieve data from the POST request
$data = json_decode(file_get_contents("php://input"), true);

// Check if necessary fields are provided
$username = trim($data['username'] ?? '');
$email = trim($data['email'] ?? '');
$password = $data['password'] ?? '';
$confirm = $data['confirm'] ?? '';

if (!$username || !$email || !$password || !$confirm) {
    echo json_encode(["success" => false, "message" => "Missing fields."]);
    exit;
}

// Check if passwords match
if ($password !== $confirm) {
    echo json_encode(["success" => false, "message" => "Passwords do not match."]);
    exit;
}

// Hash the password before storing it in the database
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Check if the username already exists
$stmt = $conn->prepare("SELECT id FROM admins WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo json_encode(["success" => false, "message" => "Username already taken."]);
    exit;
}

// Insert the new user into the database
$stmt = $conn->prepare("INSERT INTO admins (username, email, password, role) VALUES (?, ?, ?, 'admin')");
$stmt->bind_param("sss", $username, $email, $hashedPassword);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Signup successful!", "redirect" => "admin.php"]);
} else {
    echo json_encode(["success" => false, "message" => "Signup failed. Please try again."]);
}
