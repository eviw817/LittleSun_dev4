<?php
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Db.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/users/Manager.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Location.php");

if (!empty($_POST)) {
    try {
        $manager = new Manager($_POST['username'], $_POST['email'], $_POST['password'], $_POST['role'], $_POST['location'], $_POST['firstName'], $_POST['lastName']);
        if (!empty($_FILES['img']['tmp_name'])) {
            // Controleer of het bestand een afbeelding is
            $check = getimagesize($_FILES['img']['tmp_name']);
            if ($check !== false) {
                $target_dir = "../../../uploads/";
                $target_file = $target_dir . basename($_FILES["img"]["name"]);
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                // Genereer een unieke bestandsnaam
                $new_filename = uniqid() . '.' . $imageFileType;
                $target_file = $target_dir . $new_filename;

                // Verplaats het geüploade bestand naar de doelmap
                if (move_uploaded_file($_FILES["img"]["tmp_name"], $target_file)) {
                    $manager->setImage($target_file); // Sla het pad van de afbeelding op in de database
                } else {
                    throw new Exception("Sorry, there was an error uploading your file.");
                }
            } else {
                throw new Exception("File is not an image.");
            }
        }
        $manager->newManager();

        header("Location: managerList.php");
        exit();
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}



?>
<!DOCTYPE html>
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
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" required>
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
                        <?php foreach(Location::getLocations() as $location) : ?> 
                           <option value=""><?php echo $location['name']; ?></option> 
                        <?php endforeach; ?>
                    </select>
                    </div>

                    <div class="form__field">
                        <label for="img">Select image:</label>
                        <input type="file" id="img" name="img" accept="image/jpg, png" required>
                    </div>

                    <div class="form__field">
                        <input type="submit" value="Add new manager" class="btn-add">
                    </div>
            </form>
        </section>
</body>

</html>