<?php
    include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../classes/Db.php");
    include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../classes/HubLocation.php");

    $hubName = new HubLocation();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hubs</title>
    <link rel="stylesheet" href="../../css/general.css">
    <link rel="stylesheet" href="../cssManager/hub.css">
   
</head>
<body>
<?php include_once("../../header.inc.php"); ?>
    <h1 class="title">Hubs</h1>
    <div class="inline">
    <ul id="hubList">
      <?php foreach($hubName->getHubname()as $hub) : ?> 
            <a href="hubId.php?id=<?php echo $hub['id']; ?>" class="hub_detail">
                <p><?php echo $hub['name'] ; ?></p>
            </a>
        <?php endforeach; ?>  
    </ul>
    
    </div>
    
</body>
</html>