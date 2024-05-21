<?php
    include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Db.php");
    include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Schedules.php");
    include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Task.php");
    include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/users/User.php");
$error = null;

$shift = Schedules::getSheduleById($_GET["id"]);
$task = Task::getTaskById($shift["task_id"]);
$user = User::getUserById($shift["user_id"]);
if(!isset($shift)){
    $error = "The asked shift doesn't exist";
}

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shift Information</title>
    <link rel="stylesheet" href="../../../reset.css">
    <link rel="stylesheet" href="../../../shared.css">
    <link rel="stylesheet" href="./managerEventInfo.css">
</head>
<body>
<?php include_once("../../../components/headerManager.inc.php"); ?>
    <main>
    
    <h1>Shift information:</h1>
    <section>

        <p> Task: <?php echo $task["name"]; ?></p>
        <p> User: <?php echo $user["username"]; ?></p>
        <p> Day: <?php echo $shift["schedule_date"]; ?></p>
        <p> Start Time: <?php echo $shift["start_time"]; ?></p>
        <p> Start End: <?php echo $shift["end_time"]; ?></p>

        <a class="button fixed-position" href="managerCalender.php">Back</a>
        
    </section>
    </main>
     
    
</body>
</html>