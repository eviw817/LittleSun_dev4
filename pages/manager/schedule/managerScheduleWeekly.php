<?php
session_start();
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Calendar.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/users/Manager.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/users/User.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Task.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Shift.php");


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
            <p>|</p>
            <a href="<?php date("d/m/y"); ?>">Today: <?php echo date("d/m/y"); ?></a> <!-- get current week and make list of multiple weeks -->
        </div>
        <div class="agenda-info">
            <a class="link" href="managerScheduleMonthly.php">Monthly view</a> <!-- get current month and make list of multiple months -->
            <a class="link" href="#">Weekly view</a> <!-- get current week and make list of multiple weeks -->
        </div>
    </div>
    <section>
        <a class="newShift" href="#popup">New Shift</a>

        <div id="popup" class="popup">
            <div class="popup-content">
                <a href="#" class="close">&times;</a>

                <h2>Add new shift</h2>
                <div class="task">
                    <h4>Select task:</h4>
                    <select name="task" id="task">
                        <?php foreach (Task::getTasks() as $task) : ?>
                            <option value="<?php echo $task["id"] ?>"<?php echo $task['id']; ?>><?php echo $task['name']; ?></option>
                        <?php endforeach; ?>
                    </select>                    
                </div>

                <div class="user">
                    <h4>Select user:</h4>
                    <select name="user" id="user">
                        <?php foreach (User::getUsersByLocationAndRequests($managerInfo["location"]) as $user) : ?>
                            <option value="<?php echo $user["id"] ?>"<?php echo $user['id']; ?>><?php echo $user['username']; ?></option>
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
                        <label for="StartTime">Start Time:</label>
                        <input type="time" id="StartTime" name="StartTime">
                    </div>
                    <div class="endTime">
                        <label for="endTime">End Time:</label>
                        <input type="time" id="endTime" name="endTime">
                    </div>
                </div>  

                <a href="#" class="button"><button class="button" type="confirm">Confirm</button></a>

            </div>
        </div>

            <div class="cycle">
                <a href="<?php (new DateTime())->modify('-1 week')->format('W'); ?>"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000"><path d="M560-240 320-480l240-240 56 56-184 184 184 184-56 56Z"/></svg></a>
                <a href="<?php idate("W"); ?>">Current week</a>
                <a href="<?php (new DateTime())->modify('+1 week')->format('W');?>"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000"><path d="M504-480 320-664l56-56 240 240-240 240-56-56 184-184Z"/></svg></a>
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