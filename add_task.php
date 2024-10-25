<?php
session_start();
include 'includes/db.php';
include 'includes/functions.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$task = sanitize($_POST['task']);

$sql = "INSERT INTO tasks (user_id, task) VALUES ('$user_id', '$task')";

if ($conn->query($sql) === TRUE) {
    header('Location: dashboard.php');
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
?>