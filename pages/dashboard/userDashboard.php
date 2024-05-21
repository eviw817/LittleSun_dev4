<?php
    session_start(); 

    include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../classes/Db.php");
    include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../classes/users/User.php");
    if (isset($_SESSION['id'])) {
        $user = User::getUserById($_SESSION['id']);
    } else {
        
        header("Location: login.php");
        exit(); 
    }

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dasboard</title>
    <link rel="stylesheet" href="../../reset.css">
    <link rel="stylesheet" href="../../shared.css">
    <link rel="stylesheet" href="./dashboard.css">
  
</head>
<body>
<?php include_once("../../components/headerUser.inc.php"); ?>
    <h1>User Dashboard</h1>

    <section>
        <a class="link" href="../user/task/userTask.php">My task</a>
        <a class="link" href="../user/clockin_out/userClockIn.php">Clock in work</a> 
        <a class="link" href="../user/clockin_out/userClockOut.php">Clock out of work</a> 
        <a class="link" href="../user/absence/userAbsenceRequests.php">Absence requests</a>
        <!-- <a class="link" href="../user/schedule/userSchedule.php">Schedule</a> -->

        <a class="link" href="../user/calendar/userCalendar.php">Calender</a>
    </section>
   

</body>
</html>