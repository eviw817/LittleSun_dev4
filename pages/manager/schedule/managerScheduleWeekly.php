<?php
session_start();
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Calendar.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/users/Manager.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/users/User.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../..//classes/Task.php");
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
                        <input type="time" id="startTime" name="startTime" list="quarterHours">
                    </div>
                    <div class="endTime">
                        <label for="endTime">End Time:</label>
                        <input type="time" id="endTime" name="endTime" list="quarterHours">
                    </div>
                    <datalist id="quarterHours">
                        <?php for($i = 0; $i < 24; $i++): ?>
                                <option value="<?php echo ($i < 10) ? "0" . ($i) : $i ; ?>:00"></option>
                                <option value="<?php echo ($i < 10) ? "0" . ($i) : $i ; ?>:15"></option>
                                <option value="<?php echo ($i < 10) ? "0" . ($i) : $i ; ?>:30"></option>
                                <option value="<?php echo ($i < 10) ? "0" . ($i) : $i ; ?>:45"></option>
                        <?php endfor ?>
                    </datalist>
                </div>  

            <input class="button" type="submit" value="confirm"></input>

            </div>
        </div>    
    </form>
    <section>
        <div class="users">
            <div>
                       <h2 class="userList">Available users:</h2>
                <ul>
                <?php foreach (User::getUsersByLocationAndRequests($managerInfo["location"]) as $user) : ?>
                     <!-- list of users that haven't sent an absence request or have their request denied-->
                     <li><?php echo $user["username"]; ?></li>
                <?php endforeach; ?>
                </ul>     
            </div>
            <div>
                <h2 class="sicknames">Unavaible users: </h2>
                <ul>
                    <?php foreach(User::getAbsenceUsersByLocation($managerInfo["location"]) as $user) : ?>
                        <li><?php echo $user["username"]; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div class="schedule">
                        <?php foreach ($events as $event) : ?>
                            <div class="event-time"><?php echo $event['startTime']; ?> - <?php echo $event['endTime']; ?></div>
                            <div class="event-task"><?php echo $event['name']; ?></div>
                            <div class="event-user"><?php echo $event['firstName'] . " " . $event['lastName']; ?></div>
                        <?php endforeach; ?>
        </div>
    </section>


</body>

</html>