<?php
 
    include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../classes/Db.php");
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
    <link rel="stylesheet" href="../css/algemeen.css">
    <link rel="stylesheet" href="../css/hubLocation.css">
</head>
<body>
<header>
    <div class="logo">
        <img src="../images/logo.png" alt="Logo">
    </div>
</header>
<main>
    <h1 class="title">Hub location</h1>
    <ul id="locationList">
        <?php foreach(getLocationName() as $key => $location) : ?> 
            <li><a href="location.php?id=<?php echo ($key+1) ?>" class="location_detail"><?php echo $location['name']; ?> 
            </a></li>
        <?php endforeach; ?>
    </ul>
    <!-- <li><a href="location.php">Location 1</a></li>
    <li><a href="#">Location 2</a></li>
    <li><a href="#">Location 3</a></li> -->

    <a href="removeLocation.php">Add/remove locations</a>

</main>   
</body>
</html>