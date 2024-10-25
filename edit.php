<?php
session_start();
include 'includes/db.php';
include 'includes/functions.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch current user data
$sql_user = "SELECT username, email, profile_pic FROM users WHERE id='$user_id'";
$result_user = $conn->query($sql_user);
if ($result_user->num_rows > 0) {
    $user = $result_user->fetch_assoc();
    $current_username = $user['username'];
    $current_email = $user['email'];
    $current_profile_pic = $user['profile_pic'] ?? './assets/default_profile.png'; 
} else {
    echo "User not found!";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_username = sanitize($_POST['username']);
    $new_email = sanitize($_POST['email']);
    $new_password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_BCRYPT) : null;

    // Handle file upload for profile picture
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
        $target_dir = "uploads/";
        $file_name = basename($_FILES['profile_pic']['name']);
        $target_file = $target_dir . $file_name;
        $upload_ok = 1;
        $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }

        $check = getimagesize($_FILES['profile_pic']['tmp_name']);
        if ($check !== false) {
            $upload_ok = 1;
        } else {
            echo "File is not an image.";
            $upload_ok = 0;
        }

        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $upload_ok = 0;
        }

        if ($_FILES['profile_pic']['size'] > 2000000) {
            echo "Sorry, your file is too large.";
            $upload_ok = 0;
        }

        if ($image_file_type != "jpg" && $image_file_type != "png" && $image_file_type != "jpeg") {
            echo "Sorry, only JPG, JPEG, and PNG files are allowed.";
            $upload_ok = 0;
        }

        if ($upload_ok == 1) {
            if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $target_file)) {
                $sql = "UPDATE users SET profile_pic='$target_file' WHERE id='$user_id'";
                if ($conn->query($sql) === TRUE) {
                    $_SESSION['current_profile_pic'] = $target_file; 
                    $current_profile_pic = $target_file; 
                } else {
                    echo "Error updating profile picture in the database.";
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }

    // Update username and email
    $sql_update = "UPDATE users SET username='$new_username', email='$new_email' WHERE id='$user_id'";
    if ($conn->query($sql_update) === TRUE) {
        $current_username = $new_username;
        $current_email = $new_email;
        echo "Profile updated successfully!";
    } else {
        echo "Error updating profile: " . $conn->error;
    }

    // Update password if provided
    if ($new_password !== null) {
        $sql_password = "UPDATE users SET password='$new_password' WHERE id='$user_id'";
        if ($conn->query($sql_password) === TRUE) {
            echo "Password updated successfully!";
        } else {
            echo "Error updating password: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body id="editProfile">
    <div id="editBox">
        <form method="POST" enctype="multipart/form-data">
            <div id="pictureChange">
                <h3 class="yourPicture">YOUR PICTURE</h3>
                <img src="<?php echo htmlspecialchars($current_profile_pic); ?>" alt="Profile Picture" style="width: 380px; height: 200px;"><br>
            </div>
            <div class="inputPhoto">
                <input class="photo" type="file" name="profile_pic" accept="image/*"><br>
            </div>

            <div id="usernameChange">
                <input class="userChange" type="text" name="username" value="<?php echo htmlspecialchars($current_username); ?>" required><br>
            </div>

            <div id="emailChange">
                <input class="userChange" type="email" name="email" value="<?php echo htmlspecialchars($current_email); ?>" required><br>
            </div>

            <div id="passwordChange">
                <label for="password" style="color: wheat;">New Password (leave blank if you don't want to change it):</label>
                <input class="userChange" type="password" name="password"><br>
            </div>

            <div class="updateProfile">
                <button type="submit">Update Profile</button>
            </div>
        </form>
    </div>
    <div id="logOuts">
        <a href="dashboard.php">Return</a>
    </div>
</body>

</html>
