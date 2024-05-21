<?php
session_start();

include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Db.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Timetable.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/users/User.php");

if (isset($_POST['clockOutButton'])) {
    $clockOutTime = isset($_POST['clockOutTime']) ? $_POST['clockOutTime'] : null;
    $userId = isset($_SESSION['id']) ? $_SESSION['id'] : null;
    $username = isset($_POST['username']) ? $_POST['username'] : null;

    try {
        $timetable = new Timetable(null, $clockOutTime, null, null, $userId, $username);

        $timetable->clockOut();
        header("Location: userSuccesClockout.php");
        exit();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Error: Clock-out button not submitted.";
}
