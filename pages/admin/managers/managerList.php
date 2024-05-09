<?php
    include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Db.php");
    include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/users/Manager.php");
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hub managers</title>
    <link rel="stylesheet" href="../../../reset.css">
    <link rel="stylesheet" href="../../../shared.css">
    <link rel="stylesheet" href="./managerList.css">
</head>
<body>
<?php include_once("../../../components/headerAdmin.inc.php"); ?>
    <h1 class="title">Hub managers</h1>
    <div class="inline">
    <?php foreach(Manager::getHubManagerName() as $manager) : ?> 
        <div class="flex">
            <a href="managerInfo.php?id=<?php echo $manager['id']; ?>" class="manager_detail">
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
