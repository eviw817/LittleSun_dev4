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

function groupByDate($inputArray) {
    $outputArray = [];

    foreach ($inputArray as $element) {
        // Extract the date from the 'startTime' field
        $date = substr($element['startTime'], 0, 10);

        // If this date already exists in the output array, append the current element to it
        if (isset($outputArray[$date])) {
            $outputArray[$date][] = $element;
        }
        // Otherwise, create a new array for this date and add the current element to it
        else {
            $outputArray[$date] = [$element];
        }
    }

    return $outputArray;
}

$calendar = new Calendar();
if($_SESSION["id"]){
    $managerInfo = Manager::getManagerById($_SESSION["id"]);
    $events = Shift::getShiftsById($managerInfo['location'], new DateTime());
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
    <section>
        <div class="schedule">
            <?php foreach (groupByDate($events) as $key => $values) : ?>
                <h2 class="event-date"><?php echo $key; ?></h2>
                <?php foreach ($values as $event) : ?>
                    <div class="event-time">Starttime: <?php echo (new DateTime($event['startTime']))->format('H:i'); ?> - Endtime: <?php echo (new DateTime($event['endTime']))->format('H:i'); ?></div> <!-- time -->
                    <div class="event-task">Task: <?php echo $event['name']; ?></div>
                    <div class="event-user">User: <?php echo $event['firstName'] . " " . $event['lastName']; ?></div>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </div>
    </section>
</body>
</html>