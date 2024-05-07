<?php
    session_start(); 
     include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Db.php");
     include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Timetable.php");
     include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/users/User.php");

     if (isset($_SESSION['id'])) {
        $user = User::getUserById($_SESSION['id']);
        // Proceed with rendering the user dashboard
    } else {
        // Redirect or handle the case where 'id' is not set in session
        // For example, redirect the user to a login page
        header("Location: login.php");
        exit(); // Ensure script execution stops after redirection
    }
   


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
    <p><?php echo date("h:i:sa"); ?></p>
    <p><?php echo $user['username'];?></p>
    <p>Until</p>
  
    <p>Do you want to clock in?</p>
    <a href="clockInHandler.php">Clock in</a>
</body>
</html>

