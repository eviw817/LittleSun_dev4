<?php
    include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Db.php");
    include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/task.php");
    include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/users/User.php");

$error = null;
$usersAssigned = false;
$task = Task::getTaskById($_GET["id"]);
$users = User::getAllUsers();
if(!isset($task)){
   $error = "The asked task doesn't exist";
} else if(isset($users)){
   $usersAssigned = true;
}


?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Information</title>
    <link rel="stylesheet" href="../../../reset.css">
    <link rel="stylesheet" href="../../../shared.css">
    <link rel="stylesheet" href="./managerTaskAssign.css">
</head>
<body>
    <?php include_once("../../../components/header2.inc.php"); ?>
    <main>
    
    <h1>Task: <?php if($task){echo $task["name"]; }?></h1>
    <section>
        <p> Description: <?php if($task){echo $task["description"]; } ?></p>
        <p> Category: <?php if($task){echo $task["category"]; } ?></p>
        <p> Progress: <?php if($task){echo $task["progress"]; } ?></p>
        <p> Start Date: <?php if($task){echo $task["startDate"]; } ?></p>
        <p> End Date: <?php if($task){echo $task["endDate"]; } ?></p>
        <div class="form__field dropdown">
            <label for="user">Assign user:</label>
            <select name="user" id="user">
            <?php foreach($users as $user): ?>
                <option value="<?php $user['id']?>"><?php $user['username']?></option>
            <?php endforeach; ?>
            </select>
        </div>
        <a class="button fixed-position" href="./taskEdit.php?id=<?php echo $task["id"]; ?>">Edit task</a>
    </section>
    </main>
     
    
</body>
</html>