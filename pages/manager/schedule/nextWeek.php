<?php
session_start();
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Db.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Calendar.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/users/Manager.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/users/User.php");

$managerInfo = Manager::getManagerById($_SESSION["id"]);

$calendar = new Calendar();

$calendar
    ->useMondayStartingDate()
    ->addEvent(date('2024-01-14'), date('2024-01-14'), 'My Birthday', true)
    ->addEvent(date('2024-12-25'), date('2024-12-25'), 'Christmas', true)
    ->addEvent(date('2024-1-1 10:00'), date('2024-1-1 12:00'), 'Event', true);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule</title>
    <link rel="stylesheet" href="../../../reset.css">
    <link rel="stylesheet" href="../../../shared.css">
    <link rel="stylesheet" href="managerSchedule.css">
</head>

<body>
    <?php include_once("../../../components/headerManager.inc.php"); ?>
    <div class="nav">
        <div class="agenda-info">
            <h2><?php echo $managerInfo['name']; ?></h2>
            <a href="<?php date("d/m/y"); ?>">Today: <?php echo date("d/m/y"); ?></a> <!-- get current week and make list of multiple weeks -->
        </div>
        <div class="agenda-info">
            <a href="managerScheduleMonthly.php">Monthly view</a> <!-- get current month and make list of multiple months -->
            <a href="#">Weekly view</a> <!-- get current week and make list of multiple weeks -->
        </div>
    </div>
    <section>
        <button type="add">New Shift</button>
            <div class="cycle">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000"><path d="M560-240 320-480l240-240 56 56-184 184 184 184-56 56Z"/></svg>
                <a href="managerScheduleWeekly.php">Next week</a>
                <a href="nextWeek.php"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000"><path d="M504-480 320-664l56-56 240 240-240 240-56-56 184-184Z"/></svg></a>
            </div>
    </section>
    <section>
        <div class="users">
            <div >
                <h2 class="userList">Available users:</h2>
                <ul>
                <?php foreach (User::getUsersByLocationAndRequests($managerInfo["location"]) as $user) : ?>
                     <!-- list of users that haven't sent an absence request or have their request denied-->
                     <li><?php echo $user["username"]; ?></li>
                <?php endforeach; ?>
                </ul>     
            </div>
        </div>
        <div class="row">

            <div class="col-xs-12">
                
                <?php echo $calendar->useWeekView()->draw(date("Y-m-d"), 'blue'); ?>

            </div>

        </div>
    </section>


</body>

</html>