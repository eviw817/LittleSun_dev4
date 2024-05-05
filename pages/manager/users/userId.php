<?php
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Db.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/users/User.php");

// Assume User class returns user details as an associative array
if (isset($_GET['id'])) {
    $userId = $_GET['id']; 
    $taskId = $_GET['id']; 
    // Retrieve the user with the given id
    $user = User::getUserById($userId);
    $task = User::getByTask($taskId);

    if (!$user) {
        echo "User not found";
        die(); 
    }
} else {
    echo "No user ID specified";
    die(); 
}
?>

<!DOCTYPE html>
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
    <?php include_once("../../../components/header2.inc.php"); ?>
    <h1>User details</h1>
    <?php if ($user && is_array($user)): ?>
        <p>Username: <?php echo isset($user["username"]) ? $user["username"] : "N/A"; ?></p>
        <p>Firstname: <?php echo isset($user["firstName"]) ? $user["firstName"] : "N/A"; ?></p>
        <p>Lastname: <?php echo isset($user["lastName"]) ? $user["lastName"] : "N/A"; ?></p>
        <p>Email: <?php echo isset($user["email"]) ? $user["email"] : "N/A"; ?></p>
        <p>Location: <?php echo isset($user["location"]) ? $user["location"] : "N/A"; ?></p>
        <div class="image">
            <?php if (isset($user["image"]) && !empty($user["image"])): ?>
                <p>Profile picture: <img width="50px" src="<?php echo $user["image"]; ?>" alt="Profile Picture"></p>
            <?php else: ?>
                <p>No profile picture available</p>
            <?php endif; ?>
        </div>
        <?php if ($task) : ?>
            <p>Task: <?php echo isset($task["name"]) ? $task["name"] : "N/A"; ?></p>
        <?php else: ?>
            <p>No task associated with this user</p>
        <?php endif; ?>
    <?php else: ?>
        <p>User data not available</p>
    <?php endif; ?>
</body>
</html>
