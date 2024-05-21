<?php
session_start();
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Db.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/users/Manager.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Location.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/users/Admin.php");

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$admin = Admin::getAdmin($_SESSION['id']);

if (!empty($_POST)) {
    try {
        $username = $_POST["firstName"] . '.' . $_POST["lastName"];
        $manager = new Manager($username, $_POST['email'], $_POST['password'], $_POST['role'], $_POST['location'], $_POST['firstName'], $_POST['lastName']);
        if ($_FILES["img"]["size"]>0) {
            $manager->setImage('data:image/' . $_FILES['img']['type'] . ';base64,' . base64_encode(file_get_contents($_FILES['img']['tmp_name'])));
        }
        $manager->newManager();

        header("Location: managerList.php");
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
    <title>Add managers</title>
    <link rel="stylesheet" href="../../../reset.css">
    <link rel="stylesheet" href="../../../shared.css">
    <link rel="stylesheet" href="./managerAdd.css">
</head>

<body>
    <?php include_once("../../../components/headerAdmin.inc.php"); ?>
    <section class="form new_manager">
        <?php if (isset($error)) : ?>
            <div class="error">Error: <?php echo $error; ?></div>
        <?php endif; ?>

        <form action="" method="post" enctype="multipart/form-data">
            <h1>New hub manager</h2>

                <div class="form__field">
                    <label for="firstName">Firstname:</label>
                    <input type="text" id="firstName" name="firstName" required>
                </div>

                <div class="form__field">
                    <label for="lastName">Lastname:</label>
                    <input type="text" id="lastName" name="lastName" required>
                </div>

                <div class="form__field">
                    <label for="email">Email:</label>
                    <input type="text" id="email" name="email" required>
                </div>

                <div class="form__field">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form__field">
                    <label for="role">Role:</label>
                    <input type="text" id="role" name="role" value="manager" required>


                    <div class="form__field">
                        <label class="location" for="location">Hub location</label>
                        <select id="location" name="location" required>
                            <?php foreach (Location::getLocations() as $location) : ?>
                                <option value="<?php echo $location['id']; ?>"><?php echo $location['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form__field">
                        <label for="img">Select image:</label>
                        <input type="file" id="img" name="img" accept="image/*" required>
                    </div>

                    <button type="submit" class="btn-save">Save</button>
                    <a class="button fixed-position" href="managerList.php">Back</a>
        </form>
    </section>
</body>

</html>