<?php
   

    include_once("data.inc.php");

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hub Location</title>
    <link rel="stylesheet" href="styles/location.css">
</head>
<body>
    <h1>Hub location</h1>
    <?php foreach($locations as $key => $location) : ?> 
        <li><a href="location.php?id=<?php echo $key ?>" class="location_detail"><?php echo $location['location']; ?> 
        </a></li>
    <?php endforeach; ?>
    <!-- <li><a href="location.php">Location 1</a></li>
    <li><a href="#">Location 2</a></li>
    <li><a href="#">Location 3</a></li> -->

    <button onclick="window.location.href='editLocation.php'">Edit</button>
</body>
</html>