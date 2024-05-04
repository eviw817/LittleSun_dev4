<?php
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/users/Manager.php");

// wat doet dit? - Evi
/*function getLocation()
{
    $conn = Db::getConnection();
    $statement = $conn->prepare("SELECT name FROM users");
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}*/

if (!empty($_POST)) {
    try {
        $manager = new Manager($_POST['username'], $_POST['email'], $_POST['password'], $_POST['role'], $_POST['location'], $_POST['firstName'], $_POST['lastName']);

        if (isset($_POST["img"])) {
            $manager->setImage('data:image/' . $_FILES['img']['type'] . ';base64,' . base64_encode(file_get_contents($_FILES['img']['tmp_name'])));
        }

        $manager->newManager();

        header("Location: hubManagers.php");
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
    <link rel="stylesheet" href="./addManager.css">
</head>

<body>
    <?php include_once("../../../components/header2.inc.php"); ?>
    <section class="form new_manager">
        <?php if (isset($error)) : ?>
            <div class="error">Error: <?php echo $error; ?></div>
        <?php endif; ?>

            <form action="addManager.php" method="post" enctype="multipart/form-data">
                <h1>New hub manager</h2>

                    <div class="form__field">
                        <label for="firstName">Firstname:</label>
                        <input type="text" name="firstName">
                    </div>

                    <div class="form__field">
                        <label for="lastName">Lastname:</label>
                        <input type="text" name="lastName">
                    </div>

                    <div class="form__field">
                        <label for="username">Username:</label>
                        <input type="text" name="username">
                    </div>

                    <div class="form__field">
                        <label for="email">Email:</label>
                        <input type="text" name="email">
                    </div>

                    <div class="form__field">
                        <label for="password">Password:</label>
                        <input type="password" name="password">
                    </div>
                    <div class="form__field">
                        <label for="role">Role:</label>
                        <input type="text" name="role">
                    </div>

                    <div class="form__field">
                        <label for="img">Select image:</label>
                        <input type="file" id="img" name="img" accept="image/jpg, png">
                    </div>

                    <div class="form__field">
                        <input type="submit" value="Add new manager" class="btn-add">
                    </div>
            </form>
        </section>
</body>

</html>