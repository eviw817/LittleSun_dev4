<?php
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Db.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Task.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/users/User.php");


if (isset($_GET['id'])) {
    $id = $_GET['id'];
 
    $task = Task::getTaskById($id);
    $users = User::getByTask($id);
   
    if(!$task){
        echo "Task not found";
        die();
    }
} else {
    
    echo "No task ID specified";
    die(); 
}

if(isset($_POST['submit'])){

    $task = new Task($_POST["name"], $_POST["description"], $_POST["category"]);
    $task->setId($id);
    $task->updateTask();
    
  
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
<?php include_once("../../../components/headerAdmin.inc.php"); ?>
    <div class="form task_edit">
    <form action="taskEdit.php?id=<?php echo $task['id']; ?>" method="post">

            <h2 class="form__title">Edit task</h2>

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
            <p> Assigned User: 
            <?php 
            if ($users) {
                foreach ($users as $user) {
                    echo $user->getFirstname() . " " . $user->getLastname() . "<br>";
                }
            } else {
                echo "No user assigned";
            }
            ?></p>
            <!-- <div class="form__field filter">
                <label for="filter">Progress</label>
                <select name="filter" id="filter">
                    <option value="-1">No progress</option>
                    <?php foreach (Task::fetchProgress() as $progress) : ?>
                        <option value="<?php echo $progress["progress"] ?>"><?php echo $progress["progress"] ?></option>
                    <?php endforeach; ?>
                </select>
            </div> -->
           
            <div class="form__field">
                <input type="submit" name="submit" value="Save" class="btn-save">  
            </div>
            <a class="button fixed-position" href="taskList.php">Back</a>
        </form>
    </div>
</body>
</html>
