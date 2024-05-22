<?php
session_start();
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Db.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Location.php");

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

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
    <?php include_once("../../../components/headerAdmin.inc.php"); ?>
    <main>
        <h1>Hub locations</h1>
        <?php var_dump($location) ?>
        <section>
            <ul class="locationList">
                <?php foreach (Location::getLocations() as $location) : ?>
                    <a href="locationInfo.php?id=<?php echo $location["id"] ?>">
                        <li class="locationDetail"><?php echo $location['name']; ?>
                        </li>
                    </a>
                    
                <?php endforeach; ?>
            </ul>

            <a class="button fixed-position" href="locationAdd.php">Add locations</a>
            <a class="button fixed-position" href="locationRemove.php">Remove locations</a>
        </section>

    </main>
</body>

</html>