<?php
session_start();
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Db.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Location.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/users/Admin.php");

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$admin = Admin::getAdmin($_SESSION['id']);

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $location = Location::getLocationById($id);

    if (!$location) {
        echo "Location not found";
        die();
    }
} else {

    echo "No location ID specified";
    die();
}

if (isset($_POST['submit'])) {

    $location = new Location($_POST["name"], $_POST["street"], $_POST["streetNumber"], $_POST["city"], $_POST["country"], $_POST["postalCode"]);
    $location->setId($id);
    $location->updateLocation();


    header("Location: locationInfo.php?id=$id");
    exit();
}

?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit hub location</title>
    <link rel="stylesheet" href="../../../reset.css">
    <link rel="stylesheet" href="../../../shared.css">
    <link rel="stylesheet" href="./locationAdd_Edit.css">
</head>

<body>
    <?php include_once("../../../components/headerAdmin.inc.php"); ?>
    <div class="form edit_location">
        <form action="locationEdit.php?id=<?php echo $location['id']; ?>" method="post">

            <h2 class="form__title">Edit hub location</h2>

            <div class="form__field">
                <label for="name">Name</label>
                <input type="text" name="name" value="<?php echo isset($location['name']) ? $location['name'] : ''; ?>">
            </div>
            <div class="form__field">
                <label for="street">Street</label>
                <input type="text" name="street" value="<?php echo isset($location['street']) ? $location['street'] : ''; ?>">
            </div>
            <div class="form__field">
                <label for="streetNumber">Street Number</label>
                <input type="text" name="streetNumber" value="<?php echo isset($location['streetNumber']) ? $location['streetNumber'] : ''; ?>">
            </div>
            <div class="form__field">
                <label for="city">City</label>
                <input type="text" name="city" value="<?php echo isset($location['city']) ? $location['city'] : ''; ?>">
            </div>
            <div class="form__field">
                <label for="country">Country</label>
                <input type="text" name="country" value="<?php echo isset($location['country']) ? $location['country'] : ''; ?>">
            </div>
            <div class="form__field">
                <label for="postalCode">Postal Code</label>
                <input type="text" name="postalCode" value="<?php echo isset($location['postalCode']) ? $location['postalCode'] : ''; ?>">
            </div>

            <div class="form__field">
                <input type="submit" name="submit" value="Save" class="btn-save">
            </div>
            <a class="button fixed-position" href="locationList.php">Back</a>
        </form>
    </div>
</body>

</html>