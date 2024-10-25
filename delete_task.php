<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$task_id = $_GET['id'];
$sql = "DELETE FROM tasks WHERE id='$task_id'";

if ($conn->query($sql) === TRUE) {
    header('Location: dashboard.php');
} else {
    echo "Error: " . $conn->error;
}
?>