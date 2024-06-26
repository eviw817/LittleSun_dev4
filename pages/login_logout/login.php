<?php
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../classes/Db.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../classes/users/User.php");
$error = null;

if (!(isset($_POST) && empty($_POST["username"]) && empty($_POST["password"]))) {
    $user = User::getAuthorizationDetailsByUsername($_POST["username"]);

    if (!$user) {
        $error = "User does not exist. Are you already registered?";
    } else if (!password_verify($_POST["password"], $user["password"])) {
        $error = "Credentials do not match, try again.";
    } else {
        session_start();
        $_SESSION["id"] = $user['id'];
        $baseTag = '<meta http-equiv="refresh" content="0; url=';
        switch ($user["role"]) {
            case "admin":
                $redirectTag = $baseTag . '../dashboard/adminDashboard.php" />';
                break;
            case "manager":
                $redirectTag = $baseTag . '../dashboard/managerDashboard.php" />';
                break;
            case "user":
                $redirectTag = $baseTag . '../dashboard/userDashboard.php" />';
                break;
        }
    }
}

?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php if (isset($redirectTag)) {echo $redirectTag;} ?>
    <link rel="stylesheet" href="../../reset.css">
    <link rel="stylesheet" href="../../shared.css">
    <link rel="stylesheet" href="./login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@700&family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
    <title>Login</title>
    <style>
        .form__error {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <?php include_once("../../components/headerlogin.inc.php"); ?>
    <main>
        <p class="form__error"><?php if (!empty($error)) {
                                    echo $error;
                                } ?> </p>
        <form action="" method="post">
            <h2>Welcome, please log in</h2>

            <section>
                <div>
                    <label for="Username">Username</label>
                    <input id="username" type="text" name="username">
                </div>
                <div>
                    <label for="Password">Password</label>
                    <input type="password" name="password">
                </div>

                <div>
                    <input type="submit" value="Log in" class="input__button">
                    <div class="checkbox">
                        <input type="checkbox" id="rememberMe"><label for="rememberMe" class="label__inline">Remember me</label>
                    </div>
                </div>
            </section>
        </form>
    </main>
</body>

</html>