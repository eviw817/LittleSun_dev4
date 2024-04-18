<?php
 
    include_once(__DIR__ . DIRECTORY_SEPARATOR . "../classes/Db.php");
    //database geeft mij de zaken die er al in staan voor location
    function getLocationName(){
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT name FROM locations");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

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
    <?php foreach(getLocationName() as $key => $location) : ?> 
        <li><a href="location.php?id=<?php echo $key ?>" class="location_detail"><?php echo $location['name']; ?> 
        </a></li>
    <?php endforeach; ?>
    <!-- <li><a href="location.php">Location 1</a></li>
    <li><a href="#">Location 2</a></li>
    <li><a href="#">Location 3</a></li> -->

    <a href="editLocation.php">Edit locations</a>

    
</body>
</html>