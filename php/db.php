<?php
$servername = "localhost";
$username = "root";  // default user for XAMPP
$password = "";  // default password for XAMPP
$dbname = "user_management";  // replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
