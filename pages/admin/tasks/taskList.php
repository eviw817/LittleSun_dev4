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

        <div class="filter">
            <label for="filter">Filter</label>
            <select name="filter" id="filter">
                <option value="-1">No category</option>
                <?php foreach (Task::fetchAllCategories() as $category) : ?>
                    <option value="<?php echo $category["category"] ?>"><?php echo $category["category"] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <ul class="taskList">
            <?php foreach(Task::getTasks() as $task) : ?> 
                <a href="taskInfo.php?id=<?php echo $task["id"] ?>" class="taskDetail"><li><?php echo $task['name']; ?> 
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