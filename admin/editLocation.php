<?php
    include_once("data.inc.php");

    // Controleer of het formulier is ingediend om een nieuwe locatie toe te voegen
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Controleer of de locatienaam is ingevuld
        if (!empty($_POST["new_location"])) {
            // Voeg de nieuwe locatie toe aan de lijst
            $newLocation = $_POST["new_location"];
            $locations[] = array("location" => $newLocation);
            // Bewaar de bijgewerkte lijst van locaties
            file_put_contents("data.inc.php", "<?php \$locations = " . var_export($locations, true) . "; ?>");
        }
    }
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Locations</title>
    <link rel="stylesheet" href="styles/location.css">
</head>
<body>
    <h1>Edit Locations</h1>
    <h2>Existing Locations</h2>
    <ul class="location_list">
    <?php foreach($locations as $key => $location) : ?> 
        <li><?php echo $location['location']; ?></li>
    <?php endforeach; ?>
    </ul>

    <h2>Add New Location</h2>
    <a href="addLocation.php">Add locations</a>
</body>
</html>
