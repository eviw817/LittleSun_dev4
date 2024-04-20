<?php
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../classes/Db.php");

/* Zoekt voor alle managers in een locatie gebaseerd op de Location ID*/
function getManagersByLocation($locationId){
    $con = Db::getConnection();
    $statement = $con->prepare("SELECT * FROM users WHERE location = :id AND role = 'manager'");
    $statement->execute([":id" => $locationId]);
    $results = $statement->fetchAll();
    if(!$results){
        return null;
    } else {
        return $results;
    }
}

/* Geeft Hub details terug gebaseerd op de meegegeven ID*/
function getHubLocationById($hubId){
    $con = Db::getConnection();
    $statement = $con->prepare("SELECT * FROM locations WHERE id = :id");
    $statement->execute([":id" => $hubId]);
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    if(!$result){
        return null;
    } else {
        return $result;
    }
}

$error = null;
$managersAssigned = false;
$hub = getHubLocationById($_GET["id"]);
$managers = getManagersByLocation($_GET["id"]);
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
    <title>Location</title>
    <link rel="stylesheet" href="../css/algemeen.css">
</head>
<body>
    
    <h1>Hub: <?php if($hub){echo $hub["name"]; }?></h1>
    <p> Street: <?php if($hub){echo $hub["street"]; } ?></p>
    <p> Streetnumber: <?php if($hub){echo $hub["streetNumber"]; } ?></p>
    <p> City: <?php if($hub){echo $hub["city"]; } ?></p>
    <p> Country: <?php if($hub){echo $hub["country"]; } ?></p>
    <p> Postalcode: <?php if($hub){echo $hub["postalCode"]; } ?></p>
    <p> Hub manager: 
        <?php 
        if ($managers) {
            foreach ($managers as $manager) {
                echo $manager["firstName"] . " " . $manager["lastName"] . "<br>";
            }
        } else {
            echo "No manager assigned";
        }
        ?>
    
</body>
</html>