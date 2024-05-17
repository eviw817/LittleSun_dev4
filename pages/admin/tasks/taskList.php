<?php
    include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Db.php");
    include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Task.php");

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task List</title>
    <link rel="stylesheet" href="../../../reset.css">
    <link rel="stylesheet" href="../../../shared.css">
    <link rel="stylesheet" href="./taskList.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>
<body>
<?php include_once("../../../components/headerAdmin.inc.php"); ?>
<main>
    <h1>Tasks</h1>
    <section>
        <ul class="taskList">
            <?php foreach(Task::getTasks() as $task) : ?> 
                <a href="taskInfo.php?id=<?php echo $task["id"] ?>" class="taskDetail"><li><?php echo $task['name']; ?> 
                </li></a>
            <?php endforeach; ?>
        </ul>
   
        <a class="button fixed-position" href="taskAdd.php">Add tasks</a>
        <a class="button fixed-position" href="taskRemove.php">Remove tasks</a>
    </section>
</main>   
</body>
</html>