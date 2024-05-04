<?php
    include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Db.php");
    include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/location.php")

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hub Location</title>
    <link rel="stylesheet" href="../../../reset.css">
    <link rel="stylesheet" href="../../../shared.css">
    <link rel="stylesheet" href="./locationList.css">
</head>
<body>
<?php include_once("../../../components/header2.inc.php"); ?>
<main>
    <h1>Hub locations</h1>
    <section>
        <ul class="locationList">
            <?php foreach(Location::getLocations() as $location) : ?> 
                <a href="locationInfo.php?id=<?php echo $location["id"] ?>" class="locationDetail"><li><?php echo $location['name']; ?> 
                </li></a>
            <?php endforeach; ?>
        </ul>
    </section>

    <div class="button fixed-position">
    <a href="locationRemove.php">Add or remove locations</a>
    </div>
</main>   
</body>
</html>