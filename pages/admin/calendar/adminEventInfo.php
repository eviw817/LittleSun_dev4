<?php
session_start();
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Db.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Schedules.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Task.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/users/User.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/users/Manager.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Location.php");

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$manager = Manager::getManagerById($_SESSION['id']);

$error = null;

$shift = Schedules::getSheduleById($_GET["id"]);
$location = Location::getLocationById($shift["location_id"]);
$task = Task::getTaskById($shift["task_id"]);
$user = User::getUserById($shift["user_id"]);
if (!isset($shift)) {
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
    <link rel="stylesheet" href="./adminEventInfo.css">
</head>

<body>
    <?php include_once("../../../components/headerAdmin.inc.php"); ?>
    <main>

        <h1>Shift information:</h1>
        <section>

            <p> Location: <?php echo $location["name"]; ?></p>
            <p> Task: <?php echo $task["name"]; ?></p>
            <p> User: <?php echo $user["username"]; ?></p>
            <p> Day: <?php echo $shift["schedule_date"]; ?></p>
            <p> Start Time: <?php echo $shift["start_time"]; ?></p>
            <p> Start End: <?php echo $shift["end_time"]; ?></p>

            <a class="button fixed-position" href="adminCalendar.php">Back</a>

        </section>
    </main>

</body>

</html>