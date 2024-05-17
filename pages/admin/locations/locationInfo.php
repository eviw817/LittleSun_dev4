<?php
    include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Db.php");
    include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/users/Manager.php");
    include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Location.php");

$error = null;
$managersAssigned = false;
$hub = Location::getLocationById($_GET["id"]);
$managers = Manager::getByLocation($_GET["id"]);
if(!isset($hub)){
   $error = "The asked hub doesn't exist";
} else if(isset($managers)){
   $managersAssigned = true;
}


?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Location Information</title>
    <link rel="stylesheet" href="../../../reset.css">
    <link rel="stylesheet" href="../../../shared.css">
    <link rel="stylesheet" href="./locationInfo.css">
</head>
<body>
<?php include_once("../../../components/headerAdmin.inc.php"); ?>
    <main>
    
    <h1>Hub: <?php if($hub){echo $hub["name"]; }?></h1>
    <section>
        <p> Street: <?php if($hub){echo $hub["street"]; } ?></p>
        <p> Streetnumber: <?php if($hub){echo $hub["streetNumber"]; } ?></p>
        <p> City: <?php if($hub){echo $hub["city"]; } ?></p>
        <p> Country: <?php if($hub){echo $hub["country"]; } ?></p>
        <p> Postalcode: <?php if($hub){echo $hub["postalCode"]; } ?></p>
        <div class="manager">
            <p> Hub manager: </p>
            <div class="border">
                <ul class="managers">
                    <?php foreach ($managers as $manager) : ?>
                        <li><?php echo $manager['firstName'] . " " . $manager['lastName']; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <a class="button fixed-position" href="./locationEdit.php?id=<?php echo $hub["id"]; ?>">Edit location</a>
        <a class="button fixed-position" href="./locationList.php?id=<?php echo $hub["id"]; ?>">Back to locations</a>
    </section>
    </main>
     
    
</body>
</html>