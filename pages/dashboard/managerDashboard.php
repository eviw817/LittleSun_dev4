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
    <title>Manager Dashboard</title>
    <link rel="stylesheet" href="../../reset.css">
    <link rel="stylesheet" href="../../shared.css">
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
<?php include_once("../../components/headerManager.inc.php"); ?>
  
    <main>

    <h1>Manager Dashboard</h1>

    <section>
        <a class="link" href="../manager/users/userInfo.php">Users</a>
        <a class="link" href="../manager/hub/hubList.php">Hub</a>
        <a class="link" href="../manager/tasks/managerTaskList.php">Task list</a>
        <a class="link" href="../manager/approveRequest/approveDecline.php">View absence requests</a>
        <!-- <a class="link" href="../manager/schedule/managerSchedule.php">View schedule</a> -->
        <a class="link" href="../manager/reports/filter.php">Reports</a>

        <a class="link" href="../manager/calender/calender.php">Calender</a>
    </section>
    </main>
</body>
</html>

