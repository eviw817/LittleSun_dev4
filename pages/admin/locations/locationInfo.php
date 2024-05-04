<?php
    include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Db.php");
    include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/users/Manager.php");

/* Geeft Hub details terug gebaseerd op de meegegeven ID*/
function getHubLocationById($hubId){
    $conn = Db::getConnection();
    $statement = $conn->prepare("SELECT * FROM locations WHERE id = :id");
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
    <?php include_once("../../../components/header2.inc.php"); ?>
    <main>
    
    <h1>Hub: <?php if($hub){echo $hub["name"]; }?></h1>
    <section>
        <p> Street: <?php if($hub){echo $hub["street"]; } ?></p>
        <p> Streetnumber: <?php if($hub){echo $hub["streetNumber"]; } ?></p>
        <p> City: <?php if($hub){echo $hub["city"]; } ?></p>
        <p> Country: <?php if($hub){echo $hub["country"]; } ?></p>
        <p> Postalcode: <?php if($hub){echo $hub["postalCode"]; } ?></p>
        <p> Hub manager: 
            <?php 
            if ($managers) {
                foreach ($managers as $manager) {
                    echo $manager->getFirstname() . " " . $manager->getLastname() . "<br>";
                }
            } else {
                echo "No manager assigned";
            }
            ?></p>
        <a class="button fixed-position" href="./locationEdit.php?id=<?php echo $hub["id"]; ?>">Edit location</a>
    </section>
    </main>
     
    
</body>
</html>