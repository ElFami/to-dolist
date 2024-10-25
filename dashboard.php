<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

$keyword = "";
$filter = "";

// Check if the search form or filter is submitted
if (isset($_POST['search'])) {
    $keyword = $_POST['keyword'];
}

if (isset($_POST['filter_option'])) {
    $filter = $_POST['filter_option'];
}

// Base SQL query to fetch tasks for the user
$sql = "SELECT * FROM tasks WHERE user_id='$user_id'";

// Modify the query if a search keyword is provided
if (!empty($keyword)) {
    $sql .= " AND task LIKE '%$keyword%'";
}

// Modify the query based on the selected filter option
if ($filter === 'completed') {
    $sql .= " AND status = 1";  // Only completed tasks
} elseif ($filter === 'not_completed') {
    $sql .= " AND status = 0";  // Only not completed tasks
}

$result = $conn->query($sql);

// Fetch user details
$sql_user = "SELECT username, profile_pic FROM users WHERE id='$user_id'";
$result_user = $conn->query($sql_user);

if ($result_user->num_rows > 0) {
    $user = $result_user->fetch_assoc();
    $username = $user['username'];
    $profile_pic = $user['profile_pic'] ?? './assets/default_profile.png';
} else {
    $username = 'Guest';
    $profile_pic = './assets/default_profile.png';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>To-Do List Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
    <marquee class="marquee">
        ▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓ ❂ 〖Welcome, <?php echo htmlspecialchars($username); ?>!〗 ❂ ▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓
    </marquee>
</head>

<body>
    <div class="profileContainer">
        <div class="profileUpdate">
            <img src="<?php echo htmlspecialchars($profile_pic); ?>" alt="Profile Picture" class="updatedPicture">
        </div>
        <a href="edit.php" class="profile">
            <img src="./assets/profileframe.png" alt="Profile Frame">
        </a>
    </div>
    <div id="logOut">
        <a href="register.php">Log Out</a>
    </div>
    <div id="todo">
        <img class="banner" src="./assets/todo.png">
    </div>

    <div id="search">
        <!-- Search and filter form combined -->
        <form method="POST" action="">
            <!-- Search input -->
            <input type="text" name="keyword" placeholder="Search tasks..." value="<?php echo htmlspecialchars($keyword); ?>">

            <!-- Filter dropdown -->
            <select name="filter_option">
                <option value="" <?php if ($filter === '') echo 'selected'; ?>>All</option>
                <option value="completed" <?php if ($filter === 'completed') echo 'selected'; ?>>Completed</option>
                <option value="not_completed" <?php if ($filter === 'not_completed') echo 'selected'; ?>>Not Completed</option>
            </select>
            <input type="submit" name="search" value="Search & Filter">
        </form>
    </div>

    <div id="Dashboard">
        <div id="container">
            <div id="menu" style="position: relative;">
                <!-- Add task form -->
                <img class="sign" src="./assets/Sign.png">
                <form method="POST" action="add_task.php">
                    <input type="text" name="task" placeholder="New Task" required>
                    <button type="submit" class="button">
                        <div class="button-top">Add Task</div>
                        <div class="button-bottom"></div>
                        <div class="button-base"></div>
                    </button>
                </form>
            </div>

            <div id="list">
                <h2 class="to-do">Your To-Do List</h2>
                <?php if ($result->num_rows > 0) { ?>
                    <ul>
                        <?php while ($row = $result->fetch_assoc()) { ?>
                            <li class="<?php echo $row['status'] ? 'strikethrough' : ''; ?>">
                                <?php echo htmlspecialchars($row['task']); ?>
                                <button class="buttonDel-pushable" onclick="window.location.href='delete_task.php?id=<?php echo $row['id']; ?>'">
                                    <span class="buttonDel-shadow"></span>
                                    <span class="buttonDel-edge"></span>
                                    <span class="buttonDel-front">Delete</span>
                                </button>
                                <button class="buttonDel-pushable" onclick="window.location.href='update_task.php?id=<?php echo $row['id']; ?>&status=<?php echo $row['status'] ? 0 : 1; ?>'">
                                    <span class="buttonDel-shadow"></span>
                                    <span class="buttonDel-edge"></span>
                                    <span class="buttonDel-front">
                                        <?php echo $row['status'] ? 'Undo' : 'Complete'; ?>
                                    </span>
                                </button>
                            </li>
                        <?php } ?>
                    </ul>
                <?php } else { ?>
                    <p>No tasks found.</p>
                <?php } ?>
            </div>
        </div>
    </div>
</body>

</html>