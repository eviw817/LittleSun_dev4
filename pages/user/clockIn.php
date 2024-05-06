<?php
// Inclusief het databasebestand (Db.php) en maak verbinding
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../classes/Db.php");
$current_time = date('Y-m-d H:i:s'); 
$conn = Db::getConnection();

// Controleer of er op de link "Clock in" is geklikt
if (isset($_GET['clock_in'])) {
    $current_time = date('Y-m-d H:i:s'); // Huidig tijdstip inclusief seconden
    
    // Voorbereidde verklaring om het huidige tijdstip in te voegen in de database
    $statement = $conn->prepare("INSERT INTO work_logs (clock_in_time) VALUES (:clock_in_time)");
    $statement->bindValue(':clock_in_time', $current_time);
    $statement->execute([
        ":clock_in_time" => $current_time,
    ]);


}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clock in</title>
    <link rel="stylesheet" href="../../reset.css">
    <link rel="stylesheet" href="../../shared.css">
</head>
<body>
<?php include_once("../../components/headerUser.inc.php"); ?>
    <h1><?php echo $current_time;?></h1>
    <p>Name</p>
    <p>Cleaning</p>
    <p>Until</p>

    <!-- Link om in te klokken met de parameter ?clock_in=1 -->
    <p>Do you want to clock in?</p>
    <a href="userDashboard.php">Clock in</a>
</body>
</html>

