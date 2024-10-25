<?php
include 'includes/db.php';
include 'includes/functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = sanitize($_POST['username']);
    $email = sanitize($_POST['email']);
    $password = password_hash(sanitize($_POST['password']), PASSWORD_BCRYPT);

    $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";

    if ($conn->query($sql) === TRUE) {
        header('Location: login.php');
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body id="Register">
    <div id="registerBox" class="fadeIn">
        <form id="regis" method="POST">
            <br />
            <br />
            <label style="font-style: italic; text-align:center">Username: </label>
            <input type="text" name="username" required><br>

            <label style="font-style: italic; text-align:center">Email: </label>
            <input type="email" name="email" required><br>

            <label style="font-style: italic; text-align:center">Password: </label>
            <input type="password" name="password" required><br>
            <br />
            <div class="twoButton">
                <div id="logreg">
                    <button type="submit">
                        <span class="text">Sign Up |</span>
                    </button>
                </div>
                <div id="logreg">
                    <button type="button" onclick="window.location.href='login.php';">
                        <span class="text">Log in   -> |</span>
                    </button>
                </div>
            </div>

            <img class="Paper" src="./assets/paper.png">

        </form>
    </div>
</body>

</html>