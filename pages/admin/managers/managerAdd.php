<?php
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/users/Manager.php");


if (!empty($_POST)) {
    try {
        $manager = new Manager($_POST['username'], $_POST['email'], $_POST['password'], $_POST['role'], $_POST['location'], $_POST['firstName'], $_POST['lastName']);
        if (isset($_POST["img"])) {
            $manager->setImage('data:image/' . $_FILES['img']['type'] . ';base64,' . base64_encode(file_get_contents($_FILES['img']['tmp_name'])));
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
                        <option value="">Select type of absence</option>
                        <option value="Half a day">Half a day</option>
                        <option value="1 day">1 day</option>
                        <option value="More than 1 day">More than 1 day</option>
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