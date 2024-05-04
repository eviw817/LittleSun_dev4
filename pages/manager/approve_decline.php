<?php
// Inclusie van Db.php voor databaseverbinding
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../classes/Db.php");

// databaseverbinding met de statische methode getConnection() van de Db klasse
$conn = Db::getConnection();

// Goedkeuren of afwijzen van verlofaanvragen
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['approve'])) {
        $requestId = $_POST['requestId'];
        // Query om de goedkeuringsstatus van de verlofaanvraag bij te werken naar goedgekeurd
        $sql = "UPDATE absence_requests SET approvalStatus='Approved' WHERE id=$requestId";
        if ($conn->query($sql) === TRUE) {
            echo "Absence request approved successfully.";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } elseif(isset($_POST['reject'])) {
        $requestId = $_POST['requestId'];
        $reason = $_POST['reason'];
        // Query om de goedkeuringsstatus van de verlofaanvraag bij te werken naar afgewezen en de reden op te slaan
        $sql = "UPDATE absence_requests SET approvalStatus='Rejected', rejectionReason='$reason' WHERE id=$requestId";
        if ($conn->query($sql) === TRUE) {
            echo "Absence request rejected successfully.";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }
}

// Verlofaanvragen ophalen uit de database
$sql = "SELECT * FROM absence_requests";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="-dashboard">
    <h1>Manager Dashboard</h1>

    <h2>Absence Requests:</h2>

    <table>
        <tr>
            <th>Start Date & Time</th>
            <th>End Date & Time</th>
            <th>Type of Absence</th>
            <th>Reason</th>
            <th>Action</th>
        </tr>
        <?php
        if ($result->rowCount() > 0) {
            // Uitvoer van gegevens van elke rij
            while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . $row["startDateTime"] . "</td>";
                echo "<td>" . $row["endDateTime"] . "</td>";
                echo "<td>" . $row["typeOfAbsence"] . "</td>";
                echo "<td>" . $row["reason"] . "</td>";
                echo "<td>";
                // Knoppen om goed te keuren of af te wijzen
                echo "<form method='post' action=''>";
                echo "<input type='hidden' name='requestId' value='" . $row["id"] . "'>";
                echo "<input type='text' name='reason' placeholder='Reason for rejection' required>";
                echo "<button type='submit' name='approve'>Approve</button>";
                echo "<button type='submit' name='reject'>Reject</button>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No absence requests</td></tr>";
        }
        ?>
    </table>
</div>
</body>
</html>
