<?php
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../classes/Db.php");

function getLocationById($id)
{
    try {
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT l.*, u.firstName, u.lastName FROM locations l RIGHT JOIN users u ON l.id = u.location WHERE u.role = 'manager' AND l.id = :id");
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        
        // Controleer of er resultaten zijn
        if ($result) {
            return $result;
        } else {
            return false; // Geen locatie gevonden voor de opgegeven ID
        }
    } catch (PDOException $e) {
        // Handle database errors
        echo "Database Error: " . $e->getMessage();
        die(); // Stop de uitvoering van het script
    }
}

// Controleer of de locatie-ID is doorgegeven via de URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $location = getLocationById($id);
} else {
    echo "No location ID specified";
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Location</title>
</head>
<body>
    <?php if ($location) : ?>
    <h1>Hub: <?php echo $location["name"] ?></h1>
    <p> Street: <?php echo $location["street"] ?></p>
    <p> StreetNumber: <?php echo $location["streetNumber"] ?></p>
    <p> City: <?php echo $location["city"] ?></p>
    <p> Country: <?php echo $location["country"] ?></p>
    <p> Postalcode: <?php echo $location["postalCode"] ?></p>
    <p> Hub manager: <?php echo $location["firstName"] . " " . $location["lastName"] ?></p>
    <?php else : ?>
    <p>Location not found</p>
    <?php endif; ?>
</body>
</html>
