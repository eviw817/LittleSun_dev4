<?php
    include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Db.php");
    include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Calendar.php");

    //$calendar = new Calendar();

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule</title>
    <link rel="stylesheet" href="../../../reset.css">
    <link rel="stylesheet" href="../../../shared.css">
    <link rel="stylesheet" href="./managerSchedule.css">
</head>
<body>
    <?php include_once("../../../components/headerManager.inc.php"); ?>

        <div class="nav">
            <h2>Location: Hub 1</h2> <!-- getLocationByManagerId -->
            <h2>Januari</h2> <!-- get current month and make list of multiple months -->
            <h2>6/05/2024 - 12/05/2024</h2> <!-- get current week and make list of multiple weeks -->
        </div>
        <section>
            <div>
                <div class="userList">
                    <h2>Available users:</h2> <!-- list of users that haven't sent an absence request or have their request denied-->
                </div>
                <div class="userList">
                    <h2>Unavailable users:</h2> <!-- list of users that had their request approved -->
                </div>
            </div>
                <div class="timeTable"><!-- foreach -->
                    <h4>8 AM</h4>
                    <h4>9 AM</h4>
                    <h4>10 AM</h4>
                    <h4>11 AM</h4>
                    <h4>12 AM</h4>
                    <h4>13 AM</h4>
                    <h4>14 AM</h4> 
                </div>
        </section>
        
        <h1>Weekly View</h1>

        <hr />

        <div class="row">

            <div class="col-xs-12">

                <?php echo $calendar->useWeekView()->draw(date('Y-1-1'), 'blue'); ?>

            </div>

        </div>

        <hr />

        <div class="row">

            <div class="col-xs-12">

                <?php echo $calendar->useWeekView()->draw(date('Y-12-25'), 'green'); ?>

            </div>

        </div>
</body>
</html>