<?php
    include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Db.php");
    include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/task.php");

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task List</title>
    <link rel="stylesheet" href="../../../reset.css">
    <link rel="stylesheet" href="../../../shared.css">
    <link rel="stylesheet" href="./taskList.css">
</head>
<body>
<?php include_once("../../../components/header2.inc.php"); ?>
<main>
    <h1>Tasks</h1>
    <section>
        <ul class="taskList">
            <?php foreach(Task::getTasks() as $task) : ?> 
                <a href="task.php?id=<?php echo $task["id"] ?>" class="taskDetail"><li><?php echo $task['name']; ?> 
                </li></a>
            <?php endforeach; ?>
        </ul>
    </section>

    <div class="button fixed-position">
    <a href="taskRemove.php">Add or remove tasks</a>
    </div>
</main>   
</body>
</html>