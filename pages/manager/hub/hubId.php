<?php
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Db.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../Location.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/users/User.php");

$error = null;
$managersAssigned = false;

$hubData = Location::getHubLocationById($_GET["id"]);

if (!$hubData) {
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
                $users = Location::getUsersByLocation($_GET["id"]);
                if ($users) {
                    foreach ($users as $user) {
                        echo '<div class="user">';
                        if (isset($user["image"])) {
                            echo '<div class="image">';
                            echo '<img width="60px" src="' . $user["image"] . '" alt="Profile Picture">';
                            echo '</div>';
                        }
                        echo "<p class='name'>" . $user["firstName"] . " " . $user["lastName"] . "</p>";
                        
                        // Display tasks for each user
                        $tasks = User::getTaskFromUser($_GET['id']); // Use $user['id'] to fetch tasks for this user
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
