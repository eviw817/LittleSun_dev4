<?php
session_start();
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Db.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Task.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/users/Manager.php");

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$manager = Manager::getManagerById($_SESSION['id']);

?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task List</title>
    <link rel="stylesheet" href="../../../reset.css">
    <link rel="stylesheet" href="../../../shared.css">
    <link rel="stylesheet" href="./managerTaskList.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>

<body>
    <?php include_once("../../../components/headerManager.inc.php"); ?>
    <main>
        <h1>Tasks</h1>
        <section>
            <ul class="taskList">
                <?php foreach (Task::getTasks() as $task) : ?>
                    <a href="managerTaskInfo.php?id=<?php echo $task["id"] ?>" class="taskDetail">
                        <li><?php echo $task['name']; ?>
                        </li>
                    </a>
                <?php endforeach; ?>
            </ul>
        </section>
    </main>
</body>

</html>