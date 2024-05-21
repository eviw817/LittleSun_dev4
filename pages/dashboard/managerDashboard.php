<?php
session_start();
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../classes/Db.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../classes/users/Manager.php");

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$manager = Manager::getManagerById($_SESSION['id']);

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
            <a class="link" href="../manager/tasks/managerTaskList.php">Task list</a>
            <a class="link" href="../manager/approveRequest/managerApproveDecline.php">Absence requests</a>
            <a class="link" href="../manager/reports/managerFilter.php">Reports</a>
            <a class="link" href="../manager/calender/managerCalender.php">Calender</a>
        </section>
    </main>
</body>

</html>