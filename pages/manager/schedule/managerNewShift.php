<?php
session_start();

include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Db.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Shift.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Task.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/users/User.php");

if (isset($_POST['addNewShift'])) {
    $taskId = isset($_POST['task_id']) ? $_SESSION['task_id'] : null;
    $userId = isset($_POST['user']) ? $_SESSION['user_id'] : null;

    try {
        $shift = new Shift($task_id, $user_id, $shiftDate, $startTime, $endTime);

        header("Location: managerScheduleWeekly.php");
        exit();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Error: New shift not submitted.";
}