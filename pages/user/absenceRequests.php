<?php 

include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../classes/Db.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../classes/absence/Request.php");

if(!empty($_POST)){
    try{
        $request = new Request($_POST["startDateTime"], $_POST["endDateTime"], $_POST["typeOfAbsence"], $_POST["reason"]);
        $request->newRequest();
        header("Location: successMessage.php");
        exit();
    } catch(Exception $e){
        $error = $e->getMessage();
    }
}
//    $startDateTime = ($startTime != null) ? $startDate . ' ' . $startTime : $startDate;
//    $endDateTime = ($endTime != null) ? $endDate . ' ' . $endTime : $endDate;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Absence Time</title>
    <link rel="stylesheet" href="../../reset.css">
    <link rel="stylesheet" href="../../shared.css">
    <link rel="stylesheet" href="./absenceRequests.css">
</head>
<body>
<?php include_once("../../components/headerUser.inc.php"); ?>
<div class="-dashboard">
    <h1>Request absence time</h1>

    <?php if(isset($error)): ?>
      <div class="text-red-500">Error: <?php echo $error; ?></div>
    <?php endif; ?> 

    <form id="timeOffRequestForm" method="post" action="">
        <div class="form-group">
            <div class="date-time-group">
                <label for="startDate">Start Date:</label>
                <input type="date" id="startDate" name="startDate" required>
            </div>
            <div class="date-time-group">
                <label for="startTime">Start Time:</label>
                <input type="time" id="startTime" name="startTime">
            </div>
        </div>

        <div class="form-group">
            <div class="date-time-group">
                <label for="endDate">End Date:</label>
                <input type="date" id="endDate" name="endDate" required>
            </div>
            <div class="date-time-group">
                <label for="endTime">End Time:</label>
                <input type="time" id="endTime" name="endTime">
            </div>
        </div>

        <label for="typeOfAbsence">Type of Absence:</label>
        <select id="typeOfAbsence" name="typeOfAbsence" required>
            <option value="">Select type of absence</option>
            <option value="Half a day">Half a day</option>
            <option value="1 day">1 day</option>
            <option value="More than 1 day">More than 1 day</option>
        </select>

        <label for="reason">Reason:</label>
        <input type="text" id="reason" name="reason" placeholder="Enter reason" required>

        <button type="submit">Submit</button>
        <a class="link" href="../dashboard/userDashboard.php">Cancel</a>
    </form>
</div>
</body>
</html>
