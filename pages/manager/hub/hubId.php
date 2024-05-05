<?php
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Db.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/location.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/location.php");

//$hub = new Location($_POST["name"], $_POST["street"], $_POST["streetnumber"], $_POST["city"], $_POST["country"], $_POST["postalcode"]);


$error = null;
$managersAssigned = false;

// Ophalen van de hublocatie en de bijbehorende managers
$hubData = Location::getHubLocationById($_GET["id"]);
$users = Location::getUsersByLocation($_GET["id"]);

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
    <link rel="stylesheet" href="../../../reset.css">
    <link rel="stylesheet" href="../../../shared.css">
    <link rel="stylesheet" href="./hubId.css">
</head>
<body>
    <?php include_once("../../../components/header2.inc.php"); ?>
    
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
        <div class="image-container">
            <?php 
                if ($users) {
                    foreach ($users as $user) {
                        echo '<div class="user">';
                        if (isset($user["image"])) {
                            echo '<div class="image">';
                            echo '<img width="60px" src="' . $user["image"] . '" alt="Profile Picture">';
                            echo '</div>';
                        }
                        echo "<p class='name'>" . $user["firstName"] . " " . $user["lastName"] . "</p>";
                        echo '</div>';
                    }
                } else {
                    echo "No user assigned";
                }?>
            <?php endif; ?> 
            
        </div>
        
</body>
</html>
