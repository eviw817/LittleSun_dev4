<?php
session_start();

// Include de benodigde bestanden
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Db.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Timetable.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/users/User.php");

$user = User::getUserById($_SESSION['id']);


date_default_timezone_set('Africa/Lusaka');
$clockInTime = date("h:i a"); 
$clockInDay = date("d - m - Y");

$userId = $_SESSION['id'];
$username = $user['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clock out</title>
    <link rel="stylesheet" href="../../../reset.css">
    <link rel="stylesheet" href="../../../shared.css">
    <link rel="stylesheet" href="userClockIn.css">
</head>
<body>
    <?php include_once("../../../components/headerUser.inc.php"); ?>

    <h1>Clock out</h1>
    <p>Day: <?php echo $clockInDay; ?></p>
    <p>Hour: <?php echo $clockInTime; ?></p>
   

    <p>Do you want to clock out for work?</p>
    <form action="userClockOutHandler.php" method="post">
        <input type="hidden" name="clockOutTime" value="<?php echo $clockInTime; ?>">
        <input type="hidden" name="username" value="<?php echo $username; ?>">
        <input class="clockin" type="submit" name="clockOutButton" value="Clock out">
    </form>
</body>
</html>
