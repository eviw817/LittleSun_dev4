<?php
    include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../classes/Db.php");

    // Functie om de lijst van hub managers op te halen
    function getHubManagerName(){
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT id, username FROM users WHERE role = 'manager'");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hub managers</title>
    <link rel="stylesheet" href="../css/algemeen.css">
</head>
<body>
    <h1>Hub managers</h1>
    
    <?php foreach(getHubManagerName() as $manager) : ?> 
        <a href="manager.php?id=<?php echo $manager['id']; ?>" class="manager_detail"> <p><?php echo $manager['username']; ?></p> 
        </a>
    <?php endforeach; ?>


    <button onclick="window.location.href='addManager.php'">Add new hub manager</button>
    
</body>
</html>
