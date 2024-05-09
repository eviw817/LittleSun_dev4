<?php
session_start();
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Db.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/users/Manager.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Location.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $manager = Manager::getManagerById($id);
    if (!$manager) {
        echo "Manager not found";
        die();
    }
} else {
    echo "No manager ID specified";
    die();
}

if (isset($_POST['submit'])) {
    if ($_POST['location'] == "-1") {
        $location = null;
    } else {
        $location = $_POST["location"];
    }
    $username = $_POST["username"];
    $email = $_POST["email"];
    $role = $_POST["role"];
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $image = $_POST["image"];
    $updatemanager = new Manager($username, $email, $role, $firstName, $lastName, $location, $image);
    $updatemanager->setId($id);
    $updatemanager->updateInfo();

    if (isset($_POST["new-password"])) {
        $newPassword = $_POST["new-password"];
        if (!empty($newPassword)) {
            $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT, ['cost' => 12]);
            $statement = $conn->prepare("UPDATE users SET password = :password WHERE id = :id");
            $statement->execute([
                ":password" => $hashedPassword,
                ":id" => $id
            ]);
        }
    }

  
    header("Location: managerInfo.php?id=$id");
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
    <link rel="stylesheet" href="./managerEdit.css">
</head>

<body>
<?php include_once("../../../components/headerAdmin.inc.php"); ?>
    <section>
        <form action="managerEdit.php?id=<?php echo $updatemanager['id']; ?>" method="post">
            <h1>Edit hub manager</h1>

            <div class="form__field">
                <label for="username">Username:</label>
                <input type="text" name="username" value="<?php echo isset($manager['username']) ? $manager['username'] : ''; ?>">
            </div>

            <div class="form__field">
                <label for="email">Email:</label>
                <input type="text" name="email" value="<?php echo isset($manager['email']) ? $manager['email'] : ''; ?>">
            </div>

            <div class="form__field">
                <label for="new-password">Password:</label>
                <input type="password" name="new-password" value="">
            </div>

            <div class="form__field">
                <label for="role">Role:</label>
                <input type="text" name="role" value="<?php echo isset($manager['role']) ? $manager['role'] : ''; ?>">
            </div>

            <div class="form__field">
                <label for="location">Location:</label>
                <select name="location" id="location">
                    <option value="-1">No location</option>
                    <?php foreach (Location::getLocations() as $location) : ?>
                        <option value="<?php echo $location["id"] ?>" <?php echo ($location["id"] == $manager['location']) ? 'selected' : ''; ?>><?php echo $location["name"] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form__field">
                <label for="firstname">Firstname:</label>
                <input type="text" name="firstName" value="<?php echo isset($manager['firstName']) ? $manager['firstName'] : ''; ?>">
            </div>

            <div class="form__field">
                <label for="lastname">Lastname:</label>
                <input type="text" name="lastName" value="<?php echo isset($manager['lastName']) ? $manager['lastName'] : ''; ?>">
            </div>

            <div class="image">
                <?php if (isset($manager["image"])) : ?>
                    <p>Current profile picture:</p>
                    <img id="img" width="60px" src="<?php echo $manager["image"]; ?>" alt="Profile Picture">
                <?php endif; ?>
            </div>
            <div class="form__field">
                <label for="img">Select image:</label>
                <input type="file" id="img" name="img" accept="image/jpg, image/jpg">
            </div>
            <input type="submit" value="Upload Image" name="submit">



            <div class="form__field">
                <input type="submit" name="submit" value="Save" class="btn-save">
            </div>
        </form>
    </section>
</body>

</html>