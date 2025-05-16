<?php
session_start();

if (isset($_SESSION['user_id'])) {
    require_once 'db.php';

    // Log sign-out event
    $stmt = $conn->prepare("INSERT INTO signout (user_id) VALUES (?)");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
}

// Destroy session and redirect to login
session_destroy();
header("Location: index.php");
exit();
?>
