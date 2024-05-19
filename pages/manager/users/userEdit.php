<?php
session_start();
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Db.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/users/User.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Location.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $user = User::getUserById($id);
    if (!$user) {
        echo "User not found";
        die();
    }
} else {
    echo "No User ID specified";
    die();
}

if (isset($_POST['save'])) {
    $location = ($_POST['location'] == "-1") ? null : $_POST['location'];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
   
    // Haal de huidige rol van de gebruiker op
    $currentUser = User::getUserById($id);
    $role = $currentUser['role'];

    $updateuser = new User($username, $firstName, $lastName, $role, $email, $location, null);

    if (isset($_POST["img"])){
        $image = 'data:image/' . $_FILES['img']['type'] . ';base64,' . base64_encode(file_get_contents($_FILES['img']['tmp_name']));
    } else {
        $image = null;
    }
    $updateuser->setId($id);
    $updateuser->updateInfo();

    header("Location: userInfo.php?id=$id");
    exit();
}


?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit hub manager</title>
    <link rel="stylesheet" href="../../../reset.css">
    <link rel="stylesheet" href="../../../shared.css">
    <link rel="stylesheet" href="./userEdit.css">
</head>

<body>
<?php include_once("../../../components/headerUser.inc.php"); ?>
    <section class="form_edit">
    <form action="" method="post" enctype="multipart/form-data">

            <h1>Edit user</h1>

            <div class="form__field">
                <label for="username">Username:</label>
                <input type="text" name="username" value="<?php echo isset($user['username']) ? $user['username'] : ''; ?>">
            </div>

            <div class="form__field">
                <label for="firstname">Firstname:</label>
                <input type="text" name="firstName" value="<?php echo isset($user['firstName']) ? $user['firstName'] : ''; ?>">
            </div>

            <div class="form__field">
                <label for="lastname">Lastname:</label>
                <input type="text" name="lastName" value="<?php echo isset($user['lastName']) ? $user['lastName'] : ''; ?>">
            </div>

            <div class="form__field">
                <label for="email">Email:</label>
                <input type="text" name="email" value="<?php echo isset($user['email']) ? $user['email'] : ''; ?>">
            </div>

            <div class="form__field">
                <label for="location">Location:</label>
                <select name="location" id="location">
                    <option value="-1">No location</option>
                    <?php foreach (Location::getLocations() as $location) : ?>
                        <option value="<?php echo $location["id"] ?>" <?php echo ($location["id"] == $user['location']) ? 'selected' : ''; ?>><?php echo $location["name"] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- hier nog tasks toevoegen om te verander -->
            
            <div class="form__field">
                    <input type="submit" name="save" value="Save" class="btn-save">
            </div>
            <a class="button fixed-position" href="userId.php">Back</a>
        </form>
    </section>
</body>

</html>