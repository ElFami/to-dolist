<?php
function sanitize($data) {
    global $conn;
    return htmlspecialchars(mysqli_real_escape_string($conn, trim($data)));
}
?>