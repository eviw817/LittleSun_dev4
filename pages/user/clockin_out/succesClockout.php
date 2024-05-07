<?php
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $userId = $_GET['id'];
    echo "User ID: " . $userId; 

   
    $timetableData = Timetable::getDataFromTimetable($userId);

  
    
} else {
    echo "No user ID specified"; 
    die();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success clock out</title>
    <link rel="stylesheet" href="../../../reset.css">
    <link rel="stylesheet" href="../../../shared.css">
    <link rel="stylesheet" href="clockOut.css">
</head>
<body>
    <?php include_once("../../../components/headerUser.inc.php"); ?>
    <h1>You have been clocked out!</h1>

    <p>Total hours worked: <?php echo isset($timetableData['total_hours']) ? $timetableData['total_hours'] : ''; ?></p>
    <p>Start time: <?php echo isset($timetableData['clock_in_time']) ? $timetableData['clock_in_time'] : ''; ?></p>
    <p>End time: <?php echo isset($timetableData['clock_out_time']) ? $timetableData['clock_out_time'] : ''; ?></p>
    <p>Overtime hours: <?php echo isset($timetableData['overtime_hours']) ? $timetableData['overtime_hours'] : ''; ?></p>
</body>
</html>
