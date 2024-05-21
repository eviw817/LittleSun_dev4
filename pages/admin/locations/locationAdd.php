<?php
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Db.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Location.php");

$error = '';

if (!empty($_POST)) {
    try {

        $location = new Location($_POST['name'], $_POST['street'], $_POST['streetNumber'], $_POST['city'], $_POST['country'], $_POST['postalCode']);
        $location->saveLocation();

        header("Location: locationList.php");
        exit();
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add location</title>
    <link rel="stylesheet" href="../../../reset.css">
    <link rel="stylesheet" href="../../../shared.css">
    <link rel="stylesheet" href="./locationAdd_Edit.css">
</head>

<body>
    <?php include_once("../../../components/headerAdmin.inc.php"); ?>
    <section class="form add_location">
        <?php if (!empty($error)) : ?>
            <div class="error">Error: <?php echo $error; ?></div>
        <?php endif; ?>

        <form action="" method="post">
            <h2 class="form__title">Add new location</h2>

            <div class="form__field">
                <label for="name">Name</label>
                <input type="text" name="name" id="name">
            </div>
            <div class="form__field">
                <label for="street">Street</label>
                <input type="text" name="street" id="street">
            </div>
            <div class="form__field">
                <label for="streetnumber">Streetnumber</label>
                <input type="text" name="streetNumber" id="streetNumber">
            </div>
            <div class="form__field">
                <label for="city">City</label>
                <input type="text" name="city" id="city">
            </div>
            <div class="form__field">
                <label for="country">Country</label>
                <input type="text" name="country" id="country">
            </div>
            <div class="form__field">
                <label for="postalcode">Postalcode</label>
                <input type="text" name="postalCode" id="postalCode">
            </div>

            <button type="submit" class="btn-save">Save</button>
            <a class="button fixed-position" href="locationList.php">Back</a>
        </form>
    </section>
</body>

</html>