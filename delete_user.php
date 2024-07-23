<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

include 'db.php';

$id = $_GET['id'];
$sql = "DELETE FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
if ($stmt->execute([$id])) {
    header("Location: admin_dashboard.php");
    exit();
} else {
    echo "Error deleting record";
}
?>
