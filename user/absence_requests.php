<?php 
// Inclusie van Db.php voor databaseverbinding
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../classes/Db.php");

// databaseverbinding met de statische methode getConnection() van de Db klasse
$conn = Db::getConnection();

$resultMessage = '';

// verzoek om verlof in te dienen wanneer het formulier wordt ingediend (POST-methode)
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $startDateTime = $_POST['startDateTime'];
    $endDateTime = $_POST['endDateTime'];
    $typeOfAbsence = $_POST['typeOfAbsence'];
    $reason = $_POST['reason'];

    // SQL-query om het verzoek om verlof in de database in te voegen
    $sql = "INSERT INTO absence_requests (startDateTime, endDateTime, typeOfAbsence, reason) VALUES (:startDateTime, :endDateTime, :typeOfAbsence, :reason)";

    $stmt = $conn->prepare($sql);

    $stmt->bindValue(':startDateTime', $startDateTime);
    $stmt->bindValue(':endDateTime', $endDateTime);
    $stmt->bindValue(':typeOfAbsence', $typeOfAbsence);
    $stmt->bindValue(':reason', $reason);

    if ($stmt->execute()) {
      $resultMessage = "Absence request submitted successfully.";
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
    <link rel="stylesheet" href="../css/absence_requests2.css">
</head>
<body>
<div class="-dashboard">
    <h1>User Dashboard</h1>

    <div class="success-message"><?php echo $resultMessage; ?></div>

    <h2>Request Absence:</h2>

    <form id="timeOffRequestForm" method="post" action="">
        <label for="startDateTime">Start Date & Time:</label>
        <input type="datetime-local" id="startDateTime" name="startDateTime" required>
        
        <label for="endDateTime">End Date & Time:</label>
        <input type="datetime-local" id="endDateTime" name="endDateTime" required>

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
        <button type="reset">Cancel</button>
    </form>
</div>
</body>
</html>
