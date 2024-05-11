<?php
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Calendar.php");

$calendar = new Calendar();

$calendar
    ->addEvent(date('Y-01-14'), date('Y-01-14'), 'My Birthday', true)
    ->addEvent(date('Y-12-25'), date('Y-12-25'), 'Christmas', true)
    ->addEvent(date('Y-1-1 10:00'), date('Y-1-1 12:00'), 'Event', true);
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
        <a href="managerScheduleMonthly.php">Monthly view</a> <!-- get current month and make list of multiple months -->
        <a href="#">This Week</a> <!-- get current week and make list of multiple weeks -->
        <a href="#">Today</a> <!-- get current week and make list of multiple weeks -->
    </div>
    <section>
        <button type="add">New Shift</button>
    </section>
    <section>
        <div class="users">
            <div class="userList">
                <h2>Available users:</h2> <!-- list of users that haven't sent an absence request or have their request denied-->
            </div>
            <div class="userList">
                <h2>Unavailable users:</h2> <!-- list of users that had their request approved -->
            </div>
        </div>
        <div class="row">

            <div class="col-xs-12">

                <?php echo $calendar->useWeekView()->draw(date('Y-1-1'), 'blue'); ?>

            </div>

        </div>
    </section>


</body>

</html>