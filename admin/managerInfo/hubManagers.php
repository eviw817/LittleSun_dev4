<?php
    include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../classes/Db.php");

    // Functie om de lijst van hub managers op te halen
    function getHubManagerName(){
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT id, username, image FROM users WHERE role = 'manager'");
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
    <link rel="stylesheet" href="../../css/general.css">
    <link rel="stylesheet" href="../../css/hubManager.css">
</head>
<body>
<?php include_once("../header2.inc.php"); ?>
    <h1 class="title">Hub managers</h1>
    <div class="inline">
    <?php foreach(getHubManagerName() as $manager) : ?> 
        <div class="flex">
            <a href="manager.php?id=<?php echo $manager['id']; ?>" class="manager_detail">
                <p><?php echo $manager['username']; ?></p>
            </a>
            <img src="<?php echo $manager["image"]; ?>"></img>
        </div>
    <?php endforeach; ?>
    </div>
    <div class="button-container">
        <button class="newmanager" onclick="window.location.href='addManager.php'">Add new hub manager</button>
    </div>
</body>
</html>
