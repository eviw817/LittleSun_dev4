<?php
     include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Db.php");
     include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Timetable.php");

    // $time = new Timetable();


?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clock in</title>
    <link rel="stylesheet" href="../../../reset.css">
    <link rel="stylesheet" href="../../../shared.css">
</head>
<body>
<?php include_once("../../../components/headerUser.inc.php"); ?>

    <h1>Clock in</h1>
    <p>Name</p>
    <p>Until</p>
  
    <p>Do you want to clock in?</p>
    <a href="clockInHandler.php">Clock in</a>
</body>
</html>

