<?php
session_start();

if (!isset($_SESSION['role'])) {
    header("Location: ../index.php");
    exit();
}

switch ($_SESSION['role']) {
    case 'super_admin':
        header("Location: ../php/super_admin.php");
        break;
    case 'admin':
        header("Location: ../php/admin.php");
        break;
    default:
        header("Location: ../php/user_dashboard.php");
}
exit();
?>
