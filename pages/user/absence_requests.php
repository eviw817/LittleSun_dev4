<?php 
// Inclusie van Db.php voor databaseverbinding
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../classes/Db.php");

// databaseverbinding met de statische methode getConnection() van de Db klasse
$conn = Db::getConnection();

$resultMessage = '';

// verzoek om verlof in te dienen wanneer het formulier wordt ingediend (POST-methode)
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $startDate = $_POST['startDate'];
  $startTime = null;
  if (isset($_POST['startTime'])) {
      $startTime = $_POST['startTime'];
  }
  
  $endDate = $_POST['endDate'];
  $endTime = null;
  if (isset($_POST['endTime'])) {
      $endTime = $_POST['endTime'];
  }
  
  $typeOfAbsence = $_POST['typeOfAbsence'];
  $reason = $_POST['reason'];  

    // datum en tijd combineren
    $startDateTime = ($startTime != null) ? $startDate . ' ' . $startTime : $startDate;
    $endDateTime = ($endTime != null) ? $endDate . ' ' . $endTime : $endDate;

    // SQL-query om het verzoek om verlof in de database in te voegen
    $sql = "INSERT INTO absence_requests (startDateTime, endDateTime, typeOfAbsence, reason) VALUES (:startDateTime, :endDateTime, :typeOfAbsence, :reason)";

    $stmt = $conn->prepare($sql);

    $stmt->bindValue(':startDateTime', $startDateTime);
    $stmt->bindValue(':endDateTime', $endDateTime);
    $stmt->bindValue(':typeOfAbsence', $typeOfAbsence);
    $stmt->bindValue(':reason', $reason);

    if ($stmt->execute()) {
      $resultMessage = "Absence request submitted successfully.";
      header("Location: successMessage.php");
      exit; // script stopt na de redirect
    } else {
      $resultMessage = "Error: Failed to submit absence request. Please try again later.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="../../reset.css">
    <link rel="stylesheet" href="../../shared.css">
    <link rel="stylesheet" href="./absence_requests.css">
</head>
<body>
<?php include_once("../../components/header2.inc.php"); ?>
<div class="-dashboard">
    <h1>User Dashboard</h1>

    <?php if ($resultMessage): ?>
    <div class="success-message"><?php echo $resultMessage; ?></div>
    <?php else: ?>
    <h2>Request Absence:</h2>

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
        <button type="cancel" onclick="window.location.href = 'userDashboard.php';">Cancel</button>

    </form>
    <?php endif; ?>
</div>
</body>
</html>
