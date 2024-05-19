<?php
    include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Db.php");
    include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Task.php");
    include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/users/User.php");

$error = null;
$usersAssigned = false;

$task = Task::getTaskById($_GET["id"]);
$users = User::getByTask($_GET["id"]);
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
    <link rel="stylesheet" href="./managerTaskInfo.css">
</head>
<body>
<?php include_once("../../../components/headerManager.inc.php"); ?>
    <main>
    
    <h1>Task: <?php if($task){echo $task["name"]; }?></h1>
    <section>
        <p> Description: <?php if($task){echo $task["description"]; } ?></p>
        <p> Category: <?php if($task){echo $task["category"]; } ?></p>
        <!-- <p> Progress: <?php if($task){echo $task["progress"]; } ?></p>
        <p> Start Date: <?php if($task){echo $task["startDate"]; } ?></p>
        <p> End Date: <?php if($task){echo $task["endDate"]; } ?></p> -->
        <p> Assigned User: 
            <?php 
            if ($usersAssigned) {
                foreach ($users as $user) {
                    echo $user->getFirstname() . " " . $user->getLastname() . "<br>";
                }
            } else {
                echo "No user assigned";
            }
            ?></p>
        <a class="button fixed-position" href="managerTaskAssign.php?id=<?php echo $task["id"]; ?>">Add user to task</a>
        
    </section>
    </main>
     
    
</body>
</html>