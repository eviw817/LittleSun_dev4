<?php
session_start();
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Db.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/location.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/users/Manager.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/users/User.php");

if (isset($_GET["id"])) {
    $hubId = $_GET["id"];
} else {
    $error = "Hub ID is missing from the URL."; 
}
if (isset($_SESSION['id'])) {
    $error = null;
    $managerId = $_SESSION['id'];

    $manager = Manager::getManagerById($managerId);


    if ($manager) {
        $hubId = $manager['location']; 

        $hubData = Location::getHubLocationById($hubId);

        if (!$hubData) {
            $error = "De gekoppelde hub voor deze manager kon niet worden gevonden.";
        }
    } else {
        $error = "Manager niet gevonden.";
    }
} else {
    header("Location: login.php");
    exit();
}
?><!DOCTYPE html>
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
<?php include_once("../../../components/headerManager.inc.php"); ?>
    
    <?php if ($error): ?>
        <p><?php echo $error; ?></p>
    <?php else: ?>
        <h1>Hub: <?php echo $hubData["name"]; ?></h1>
        <p>Street: <?php echo $hubData["street"]; ?></p>
        <p>Streetnumber: <?php echo $hubData["streetNumber"]; ?></p>
        <p>City: <?php echo $hubData["city"]; ?></p>
        <p>Country: <?php echo $hubData["country"]; ?></p>
        <p>Postalcode: <?php echo $hubData["postalCode"]; ?></p>
        <p>Users:</p>
        <div class="image-container">
            <?php 
                $users = Location::getUsersByLocation($hubId);
                if ($users) {
                    foreach ($users as $user) {
                        echo '<div class="user">';
                        if (isset($user["image"])) {
                            echo '<div class="image">';
                            echo '<img width="60px" src="' . $user["image"] . '" alt="Profile Picture">';
                            echo '</div>';
                        }
                        echo "<p class='name'>" . $user["firstName"] . " " . $user["lastName"] . "</p>";
                        
                        $tasks = User::getTaskFromUser( $hubId); 
                        if ($tasks) {
                            echo '<div class="task">';
                            echo "<p>Tasks:</p>";
                            echo "<ul class='taskList'>";
                            foreach ($tasks as $task) {
                                echo "<li>" . $task["name"] . "</li>";
                            }
                            echo "</ul>";
                        } else {
                            echo "<p>No tasks assigned</p>";
                        }
                        echo '</div>';
                        
                        echo '</div>'; 
                    }
                } else {
                    echo "No users assigned";
                }
            ?>
        </div>
    <?php endif; ?> 

    </body>
</html>