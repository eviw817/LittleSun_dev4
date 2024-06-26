<?php
session_start();

include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/users/User.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Task.php");

if (isset($_SESSION['id'])) {
    $user = User::getUserById($_SESSION['id']);
    $userId = $_SESSION['id'];
    $tasks = Task::getTasksByUserId($_SESSION['id']); 
} else {
    header("Location: login.php");
    exit();
}

?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Task</title>
    <link rel="stylesheet" href="../../../reset.css">
    <link rel="stylesheet" href="../../../shared.css">
    <link rel="stylesheet" href="./userTask.css">
</head>

<body>
    <?php include_once("../../../components/headerUser.inc.php"); ?>
    <h1>Hi, <?php echo $user['username']; ?></h1>
    <h2>Your tasks:</h2>
    <?php foreach ($tasks as $task) : ?>
            <p><?php echo $task['name']; ?></p>
    <?php endforeach; ?>
</body>

</html>