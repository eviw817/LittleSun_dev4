<?php
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../classes/Db.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../classes/HubLocation.php");

$hub = new HubLocation();

$error = null;
$managersAssigned = false;

// Ophalen van de hublocatie en de bijbehorende managers
$hubData = $hub->getHubLocationById($_GET["id"]);
$users = $hub->getUsersByLocation($_GET["id"]);

if(!$hubData){
   $error = "The requested hub doesn't exist";
} else {
   $managersAssigned = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Location</title>
    <link rel="stylesheet" href="../../css/general.css">
</head>
<body>
    <?php include_once("../../header.inc.php"); ?>
    
    <?php if ($error): ?>
        <p><?php echo $error; ?></p>
    <?php else: ?>
        <h1>Hub: <?php echo $hubData["name"]; ?></h1>
        <p> Street: <?php echo $hubData["street"]; ?></p>
        <p> Streetnumber: <?php echo $hubData["streetNumber"]; ?></p>
        <p> City: <?php echo $hubData["city"]; ?></p>
        <p> Country: <?php echo $hubData["country"]; ?></p>
        <p> Postalcode: <?php echo $hubData["postalCode"]; ?></p>
        <p> Users: 
        <?php 
        if ($users) {
            foreach ($users as $user) {
                echo "<p>" . $user["firstName"] . " " . $user["lastName"] . "</p>";
                if (isset($user["image"])) {
                    echo '<div class="image">';
                    echo '<img width="70px" src="' . $user["image"] . '" alt="Profile Picture">';
                    echo '</div>';
                }
            }
        } else {
            echo "No user assigned";
        }?>
    <?php endif; ?>
</body>
</html>
