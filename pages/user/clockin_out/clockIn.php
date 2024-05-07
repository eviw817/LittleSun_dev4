<?php
    session_start(); 
     include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Db.php");
     include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Timetable.php");
     include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/users/User.php");

     if (isset($_SESSION['id'])) {
        $user = User::getUserById($_SESSION['id']);
    } else {
        header("Location: login.php");
    }
   


?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clock in</title>
    <link rel="stylesheet" href="../../../reset.css">
    <link rel="stylesheet" href="../../../shared.css">
    <link rel="stylesheet" href="clockIn.css">
</head>
<body>
<?php include_once("../../../components/headerUser.inc.php"); ?>

    <h1>Clock in</h1>
    <?php date_default_timezone_set('Africa/Lusaka');?>
    <p>Day: <?php echo date("d - m - Y"); ?></p>
    <p>Hour: <?php echo date("h : i a"); ?></p>
    <p><?php echo $user['username'];?></p>

    <p>Do you want to clock in?</p>
    <a class="clockin" href="clockInHandler.php">Clock in</a>
</body>
</html>

