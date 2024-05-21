<?php
session_start();
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Db.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/absence/Request.php");

if(!empty($_POST)){
    try{
        $startDateTime = ($_POST['startTime'] != null) ? $_POST['startDate'] . ' ' . $_POST['startTime']: $_POST['startDate'] . ' 00:00:00';
        $endDateTime = ($_POST['endTime'] != null) ? $_POST['endDate'] . ' ' . $_POST['endTime'] : $_POST['endDate'] . ' 00:00:00';
        $request = new Request($startDateTime, $endDateTime, $_POST["typeOfAbsence"], $_POST["reasonType"]);
        $request->newRequest($_SESSION['id']);
        header("Location: successMessage.php");
        exit();
    } catch(Exception $e){
        $error = $e->getMessage();
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Absence</title>
    <link rel="stylesheet" href="../../../reset.css">
    <link rel="stylesheet" href="../../../shared.css">
    <link rel="stylesheet" href="./userAbsenceRequests.css">
</head>
<body>
<?php include_once("../../../components/headerUser.inc.php"); ?>
<div class="-dashboard">
    <?php if(isset($error)): ?>
      <div class="text-red-500">Error: <?php echo $error; ?></div>
    <?php endif; ?> 
    <h1>Request Absence</h1>

    <form id="timeOffRequestForm" method="post" action="">
        <div class="form-group">
            <div class="date-time-group">
                <label for="startDate">Start date:</label>
                <input type="date" id="startDate" name="startDate" required>
            </div>
            <div class="date-time-group">
                <label for="startTime">Start time:</label>
                <input type="time" id="startTime" name="startTime">
            </div>
        </div>

        <div class="form-group">
            <div class="date-time-group">
                <label for="endDate">End date:</label>
                <input type="date" id="endDate" name="endDate" required>
            </div>
            <div class="date-time-group">
                <label for="endTime">End time:</label>
                <input type="time" id="endTime" name="endTime">
            </div>
        </div>

        <label for="typeOfAbsence">Length of absence:</label>
        <select id="typeOfAbsence" name="typeOfAbsence" required>
            <option value="">Select type of absence</option>
            <option value="Half a day">Half a day</option>
            <option value="1 day">1 day</option>
            <option value="More than 1 day">More than 1 day</option>
        </select>

        <label for="reasonType">Reason:</label>
        <select id="reasonType" name="reasonType" required>
            <option value="">Reason of abscence</option>
            <option value="Sick leave">Sick leave</option>
            <option value="Vacation">Vacation</option>
            <option value="Birthday">Birthday</option>
            <option value="Maternity">Maternity</option>
            <option value="Funeral">Funeral</option>
            <option value="Wedding">Wedding</option>
            <option value="Compensary time">Compensary time</option>
            <option value="Authority appointment">Authority appointment</option>
            <option value="Other">Other</option>
        </select>
       

        <button type="submit">Submit</button>
        <a href="../dashboard/userDashboard.php">Cancel</a>

    </form>
</div>

</body>
</html>