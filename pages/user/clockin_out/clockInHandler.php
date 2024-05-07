<?php
session_start();

include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Db.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Timetable.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/users/User.php");


if (isset($_POST['clockInButton'])) {
    $clockInTime = isset($_POST['clockInTime']) ? $_POST['clockInTime'] : null;
    $userId = isset($_SESSION['id']) ? $_SESSION['id'] : null;
    $username = isset($_POST['username']) ? $_POST['username'] : null;

   
    try {
    
        $timetable = new Timetable($clockInTime, null, null, null, $userId, $username);

        $timetable->clockIn();
        header("Location: succesClockin.php");
        exit();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Error: Clock-in button not submitted.";
}
?>
