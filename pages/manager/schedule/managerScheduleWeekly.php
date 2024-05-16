<?php
session_start();
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Calendar.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/users/Manager.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/users/User.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Task.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Shift.php");

if (!empty($_POST)) {
    $shift = new Shift($_POST['task'], $_POST['user'], $_POST['date'], $_POST['startTime'], $_POST['endTime']);
    $shift->newShift();
}

$calendar = new Calendar();
if($_SESSION["id"]){
    $managerInfo = Manager::getManagerById($_SESSION["id"]);
    $events = Shift::getShiftsById($managerInfo['location']);
    foreach ($events as $event) {
        $calendar->addEvent($event['startTime'], $event['endTime']);
    }
} else {
    echo "Error: Session is invalid, please log-in again";
}

$calendar
    ->useMondayStartingDate()
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
            <p>|</p>
            <a href="<?php date("d/m/y"); ?>">Today: <?php echo date("d/m/y"); ?></a> <!-- get current week and make list of multiple weeks -->
        </div>
        <div class="agenda-info">
            <a class="link" href="managerScheduleMonthly.php">Monthly view</a> <!-- get current month and make list of multiple months -->
            <a class="link" href="#">Weekly view</a> <!-- get current week and make list of multiple weeks -->
        </div>
    </div>
    <form action="" method="post">
        <a class="newShift" href="#popup">New Shift</a>

        <div id="popup" class="popup">
            <div class="popup-content">
                <a href="#" class="close">&times;</a>

                <h2>Add new shift</h2>
                <div class="task">
                    <h4>Select task:</h4>
                    <select name="task" id="task">
                        <?php foreach (Task::getTasks() as $task) : ?>
                            <option value="<?php echo $task["id"] ?>"><?php echo $task['name']; ?></option>
                        <?php endforeach; ?>
                    </select>                    
                </div>

                <div class="user">
                    <h4>Select user:</h4>
                    <select name="user" id="user">
                        <?php foreach (User::getUsersByLocationAndRequests($managerInfo["location"]) as $user) : ?>
                            <option value="<?php echo $user["id"] ?>"><?php echo $user['username']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>       
                
                <div class="shift">
                    <h4>Shift:</h4>
                    <div class="date">
                        <label for="date">Date:</label>
                        <input type="date" id="date" name="date">
                    </div>
                    <div class="startTime">
                        <label for="startTime">Start Time:</label>
                        <input type="time" id="startTime" name="startTime">
                    </div>
                    <div class="endTime">
                        <label for="endTime">End Time:</label>
                        <input type="time" id="endTime" name="endTime">
                    </div>
                </div>  

            <input class="button" type="submit" value="confirm"></input>

            </div>
        </div>    
    </form>
            <div class="cycle">
                <a href="<?php (new DateTime())->modify('-1 week')->format('W'); ?>"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000"><path d="M560-240 320-480l240-240 56 56-184 184 184 184-56 56Z"/></svg></a>
                <a href="<?php idate("W"); ?>">Current week</a>
                <a href="<?php (new DateTime())->modify('+1 week')->format('W');?>"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000"><path d="M504-480 320-664l56-56 240 240-240 240-56-56 184-184Z"/></svg></a>
            </div>

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