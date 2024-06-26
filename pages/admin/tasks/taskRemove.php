<?php
session_start();
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Db.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Task.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/users/Admin.php");

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$admin = Admin::getAdmin($_SESSION['id']);

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id"])) {
    $taskId = $_POST["id"];
    Task::deleteTask($taskId);
    // Reload the page to reflect the changes
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete task</title>
    <link rel="stylesheet" href="../../../reset.css">
    <link rel="stylesheet" href="../../../shared.css">
    <link rel="stylesheet" href="./taskRemove.css">
</head>

<body>
    <?php include_once("../../../components/headerAdmin.inc.php"); ?>
    <div class="flex">
        <h1>Task</h1>
        <ul class="taskList">

            <?php foreach (Task::getTasks() as $key => $task) : ?>
                <li>
                    <section>
                        <a href="taskInfo.php?id=<?php echo ($key + 1) ?>" class="task_detail"><?php echo $task['name']; ?> </a>
                        <form action="" method="post" onsubmit="return confirm('Are you sure you want to delete this task?')">
                            <input type="hidden" name="id" value="<?php echo $task['id']; ?>">
                            <button type="submit">Remove task</button>
                        </form>
                    </section>
                </li>
            <?php endforeach; ?>
        </ul>

        <a class="button fixed-position" href="taskList.php">Back</a>
    </div>

</body>

</html>