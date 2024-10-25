<?php
include 'includes/db.php';
include 'includes/functions.php';


session_start();

$warningMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = sanitize($_POST['email']);
    $password = sanitize($_POST['password']);

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header('Location: dashboard.php');
        } else {
            $warningMessage = "Invalid password.";
        }
    } else {
        $warningMessage = "No user found with this email.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body id="Login">
    <div id="loginBox">
        <form id="logins" method="POST">
            <h2>Login</h2>
            <br /> <br />
            <label>Email: </label><input type="email" name="email" required><br>
            <br />
            <label>Password: </label><input type="password" name="password" required><br>
            <br /> <br />
            <div id="logreg"><button type="submit"><span class="text">Login → |</span></button></div>

            <img class="Paper" src="./assets/login.png">
        </form>
    </div>
</body>
<div id="warning" class="warning-box"><?php echo $warningMessage; ?></div>

<script>
    const warningBox = document.getElementById('warning');
    if (warningBox.innerHTML.trim() !== '') {
        warningBox.classList.add('show ');
        setTimeout(() => {
            warningBox.classList.remove('show');
        }, 3000);
    }
</script>

</html>