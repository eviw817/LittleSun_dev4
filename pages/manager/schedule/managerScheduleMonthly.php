<?php
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Calendar.php");

$calendar = new Calendar();

$calendar
    ->addEvent(date('Y-01-14'), date('Y-01-14'), 'My Birthday', true)
    ->addEvent(date('Y-12-25'), date('Y-12-25'), 'Christmas', true)
    ->addEvent(date('Y-1-1 10:00'), date('Y-1-1 12:00'), 'Time Event', true);


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
        <a href="managerScheduleWeekly.php">Weekly view</a> <!-- get current month and make list of multiple months -->
    </div>
    <section>
        <div class="row fix">

            <div class="col-xs-12 col-sm-6 col-md-4">

                <?php echo $calendar->draw(date('Y-1-1'), ''); ?>

                <hr />

            </div>

            <div class="col-xs-12 col-sm-6 col-md-4">

                <?php echo $calendar->draw(date('Y-2-1'), 'pink'); ?>

                <hr />

            </div>

            <div class="col-xs-12 col-sm-6 col-md-4">

                <?php echo $calendar->draw(date('Y-3-1'), 'blue'); ?>

                <hr />

            </div>

            <div class="col-xs-12 col-sm-6 col-md-4">

                <?php echo $calendar->draw(date('Y-4-1'), 'orange'); ?>

                <hr />

            </div>

            <div class="col-xs-12 col-sm-6 col-md-4">

                <?php echo $calendar->draw(date('Y-5-1'), 'purple'); ?>

                <hr />

            </div>

            <div class="col-xs-12 col-sm-6 col-md-4">

                <?php echo $calendar->draw(date('Y-6-1'), 'yellow'); ?>

                <hr />

            </div>

            <div class="col-xs-12 col-sm-6 col-md-4">

                <?php echo $calendar->draw(date('Y-7-1'), 'green'); ?>

                <hr />

            </div>

            <div class="col-xs-12 col-sm-6 col-md-4">

                <?php echo $calendar->draw(date('Y-8-1'), 'grey'); ?>

                <hr />

            </div>

            <div class="col-xs-12 col-sm-6 col-md-4">

                <?php echo $calendar->draw(date('Y-9-1'), 'pink'); ?>

                <hr />

            </div>

            <div class="col-xs-12 col-sm-6 col-md-4">

                <?php echo $calendar->draw(date('Y-10-1'), 'blue'); ?>

            </div>

            <div class="col-xs-12 col-sm-6 col-md-4">

                <?php echo $calendar->draw(date('Y-11-1'), 'orange'); ?>

            </div>

            <div class="col-xs-12 col-sm-6 col-md-4">

                <?php echo $calendar->draw(date('Y-12-1'), 'purple'); ?>

                <hr />

            </div>

        </div>
    </section>

</body>

</html>