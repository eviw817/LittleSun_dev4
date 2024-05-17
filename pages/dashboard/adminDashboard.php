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
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../../reset.css">
    <link rel="stylesheet" href="../../shared.css">
    <link rel="stylesheet" href="./dashboard.css">
    
</head>
<body>
    <?php include_once("../../components/headerAdmin.inc.php"); ?>

    <main>
        <h1>Admin Dashboard</h1>

        <section>
            
            <a class="link" href="../admin/locations/locationList.php">Hub locations</a>

            <a class="link" href="../admin/managers/managerList.php">Hub managers</a>

            <a class="link" href="../admin/tasks/taskList.php">Task list</a>


        </section>

    </main>
</body>
</html>