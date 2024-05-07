<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Succes clock in</title>
    <link rel="stylesheet" href="../../../reset.css">
    <link rel="stylesheet" href="../../../shared.css">
    <link rel="stylesheet" href="clockIn.css">
</head>
<body>
<?php include_once("../../../components/headerUser.inc.php"); ?>
    <h1>You have been clock out!</h1>
    
</body>
</html>

<!-- <?php
    include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Db.php");
    include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Timetable.php");
    include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/users/User.php");

    // Assuming you have a Timetable object with the clock-in and clock-out times
    $timetable = new Timetable($clockInTime, $clockOutTime, $totalHours, $overtimeHours, $userId, $username);

    // Calculate the total hours worked and overtime hours
    $interval = date_diff(date_create($clockInTime), date_create($clockOutTime));
    $totalHours = $interval->h + ($interval->i / 60);
    $standardWorkHours = 8; // Standard hours per workday
    $overtimeHours = max($totalHours - $standardWorkHours, 0);

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success clock out</title>
    <link rel="stylesheet" href="../../../reset.css">
    <link rel="stylesheet" href="../../../shared.css">
    <link rel="stylesheet" href="clockOut.css">
</head>
<body>
<?php include_once("../../../components/headerUser.inc.php"); ?>
    <h1>You have been clocked out!</h1>

    <p>Total hours worked: <?php echo $totalHours; ?></p>
    <p>Start time:<?php echo $clockInTime; ?></p>
    <p>End time:<?php echo $clockOutTime ;?></p>
    <p>Overtime hours: <?php echo$overtimeHours; ?></p>

</body>
</html> -->