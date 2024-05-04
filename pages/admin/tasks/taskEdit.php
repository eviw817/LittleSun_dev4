<?php
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Db.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/task.php");

// Controleren of er een task ID is opgegeven in de URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Taskgegevens ophalen
    $task = Task::getTaskById($id);
    // Controleren of de task bestaat
    if(!$task){
        echo "Task not found";
        die();
    }
} else {
    // Als er geen ID is opgegeven, stop de uitvoering en geef een foutmelding weer
    echo "No task ID specified";
    die(); 
}

if(isset($_POST['submit'])){
    // Verwerk de formuliargegevens en update de gegevens in de database
    $task = new Task($_POST["name"], $_POST["description"], $_POST["category"], $_POST["progress"], $_POST["startDate"], $_POST["endDate"]);
    $task->setId($id);
    $task->updateTask();
    
    // Redirect naar de detailpagina met de bijgewerkte gegevens
    header("Location: taskInfo.php?id=$id");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <link rel="stylesheet" href="../../../reset.css">
    <link rel="stylesheet" href="../../../shared.css">
    <link rel="stylesheet" href="./taskAdd_Edit.css">
</head>
<body>
    <?php include_once("../../../components/header2.inc.php"); ?>
    <div class="form task_edit">
    <form action="taskEdit.php?id=<?php echo $task['id']; ?>" method="post">

            <h2 class="form__title">Edit Task</h2>

            <div class="form__field">
                <label for="name">Name</label>
                <input type="text" name="name" value="<?php echo isset($task['name']) ? $task['name'] : ''; ?>">
            </div>
            <div class="form__field">
                <label for="description">Description</label>
                <input type="text" name="description" value="<?php echo isset($task['description']) ? $task['description'] : ''; ?>">
            </div>
            <div class="form__field">
                <label for="category">Category</label>
                <input type="text" name="category" value="<?php echo isset($task['category']) ? $task['category'] : ''; ?>">
            </div>
            <div class="form__field filter">
                <label for="filter">Progress</label>
                <select name="filter" id="filter">
                    <option value="-1">No progress</option>
                    <?php foreach (Task::fetchProgress() as $progress) : ?>
                        <option value="<?php echo $progress["progress"] ?>"><?php echo $progress["progress"] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form__field">
                <label for="startDate">Start Date</label>
                <input type="text" name="startDate" value="<?php echo isset($task['startDate']) ? $task['startDate'] : ''; ?>">
            </div>
            <div class="form__field">
                <label for="endDate">End Date</label>
                <input type="text" name="endDate" value="<?php echo isset($task['endDate']) ? $task['endDate'] : ''; ?>">
            </div>

            <div class="form__field">
                <input type="submit" name="submit" value="Save" class="btn-save">  
            </div>
        </form>
    </div>
</body>
</html>
