<?php
    session_start();
    include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Db.php");
    include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../Location.php");
    include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/users/Manager.php");

    if (isset($_SESSION['id'])) {
    
        $user = Manager::getManagerById($_SESSION['id']);
    
    
        $userId = $_SESSION['id'];
        $manager = $user['username'];
    
    
    } else {
        header("Location: login.php");
        exit();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hubs</title>
    <link rel="stylesheet" href="../../../reset.css">
    <link rel="stylesheet" href="../../../shared.css">
    <link rel="stylesheet" href="./hubList.css">
   
</head>
<body>
<?php include_once("../../../components/headerManager.inc.php"); ?>
    <h1 class="title">Hubs</h1>
    <div class="inline">
    <ul id="hubList">
      <?php foreach(Location::getHubname()as $hub) : ?> 
            <a href="hubId.php?id=<?php echo $hub['id']; ?>" class="hub_detail">
                <p><?php echo $hub['name'] ; ?></p>
            </a>
        <?php endforeach; ?>  
    </ul>
    
    </div>
    
</body>
</html>