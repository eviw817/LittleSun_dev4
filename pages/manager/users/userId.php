<?php
session_start();
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Db.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/users/User.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/users/Manager.php");

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$manager = Manager::getManagerById($_SESSION['id']);

// Assume User class returns user details as an associative array
if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    $taskId = $_GET['id'];
    // Retrieve the user with the given id
    $user = User::getUserById($userId);
    $tasks = User::getByTask($taskId);

    if (!$user) {
        echo "User not found";
        die();
    }
} else {
    echo "No user ID specified";
    die();
}
?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User details</title>
    <link rel="stylesheet" href="../../../reset.css">
    <link rel="stylesheet" href="../../../shared.css">
    <link rel="stylesheet" href="./userId.css">
</head>

<body>
    <?php include_once("../../../components/headerManager.inc.php"); ?>
    <h1>User details</h1>
    <?php if ($user && is_array($user)) : ?>
        <p>Username: <?php echo isset($user["username"]) ? $user["username"] : "N/A"; ?></p>
        <p>Firstname: <?php echo isset($user["firstName"]) ? $user["firstName"] : "N/A"; ?></p>
        <p>Lastname: <?php echo isset($user["lastName"]) ? $user["lastName"] : "N/A"; ?></p>
        <p>Email: <?php echo isset($user["email"]) ? $user["email"] : "N/A"; ?></p>
        <p>Location: <?php echo isset($user["location"]) ? $user["location"] : "N/A"; ?></p>
        <div class="image">
            <?php if (isset($user["image"]) && !empty($user["image"])) : ?>
                <p>Profile picture: <img width="50px" src="<?php echo $user["image"]; ?>" alt="Profile Picture"></p>
            <?php else : ?>
                <p>No profile picture available</p>
            <?php endif; ?>
        </div>
        <div>
            <p>Assigned tasks:</p>
            <?php if ($tasks) : ?>
                <ul class='taskList'>
                    <?php foreach ($tasks as $task) : ?>
                        <li><?php echo $task["name"]; ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php else : ?>
                <p>No tasks assigned</p>
            <?php endif; ?>
        </div>

    <?php else : ?>
        <p>User data not available</p>
    <?php endif; ?>

    <div class="edit-link">
        <a class="edit" href="userEdit.php?id=<?php echo $_GET['id']; ?>">Edit user</a>
    </div>
    <div class="edit-link">
        <a class="edit" href="UserInfo.php">Back</a>
    </div>
</body>

</html>