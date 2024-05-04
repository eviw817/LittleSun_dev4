<?php
    include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Db.php");
    include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/location.php");

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id"])) {
        $locationId = $_POST["id"];
        Location::deleteLocation($locationId);
        // Reload the page to reflect the changes
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit location</title>
    <link rel="stylesheet" href="../../../reset.css">
    <link rel="stylesheet" href="../../../shared.css">
    <link rel="stylesheet" href="./locationRemove.css">
</head>

<body>
    <?php include_once("../../../components/header2.inc.php"); ?>

    <h1>Hub location</h1>
    <ul>

        <?php foreach (Location::getLocationName() as $key => $location) : ?>
            <li>
                <section>
                    <a href="locationInfo.php?id=<?php echo ($key + 1) ?>" class="location_detail"><?php echo $location['name']; ?> </a>
                    <form action="" method="post" onsubmit="return confirm('Are you sure you want to delete this location?')">
                        <input type="hidden" name="id" value="<?php echo $location['id']; ?>">
                        <button type="submit">Remove location</button>
                    </form>
                </section>
            </li>
        <?php endforeach; ?>
    </ul>

    <a class="button fixed-position" href="./locationAdd.php?id=<?php echo $hub["id"]; ?>">Add location +</a>

</body>

</html>




</body>

</html>