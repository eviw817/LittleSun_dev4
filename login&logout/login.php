<?php
    include_once(__DIR__ . DIRECTORY_SEPARATOR . "../classes/Db.php");

    function getAuthorizationDetailsByUsername($pUsername){
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT username, password, role FROM users WHERE username = :tUsername");
        $statement->execute([":tUsername" => $pUsername]);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    $error = null;
    
    if(!(isset($_POST) && empty($_POST["username"]) && empty($_POST["password"]))){
        $user = getAuthorizationDetailsByUsername($_POST["username"]);

        if(!$user){
            $error = "User does not exist!";
        }else if($user["password"] != $_POST["password"]){
            $error = "Credentials do not match!";
        } else {
            $baseTag = '<meta http-equiv="refresh" content="0; url=';
            switch ($user["role"] ) {
                case "admin":
                    $redirectTag = $baseTag . '../admin/adminDashboard.php" />';
                    break;
                case "manager":
                    $redirectTag = $baseTag . '../manager/managerDashboard.php" />';
                    break;
                case "user":
                    $redirectTag = $baseTag . '../user/userDashboard.php" />';
                    break;
            }
        }
    }

    
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
        if(isset($redirectTag)){
            echo $redirectTag;
        }
    ?>
    <link rel="stylesheet" href="../css/general.css">
    <link rel="stylesheet" href="../css/login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@700&family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
    <title>Login</title>
</head>

<body>
    <?php include_once("../header.inc.php"); ?>
<main>
    <p><?php if(!empty($error)){echo $error;} ?>
    <form action="" method="post">
        <h2>Welcome, please log in</h2>

        <div class="full__form">
            <div class="form__field">
                <label for="Username">Username</label>
                <input id="username" type="text" name="username">
            </div>
            <div class="form__field">
                <label for="Password">Password</label>
                <input type="password" name="password">
            </div>

            <div class="form__field">
                <input type="submit" value="Log in" class="input__button">
                <div class="checkbox">
                    <input type="checkbox" id="rememberMe"><label for="rememberMe" class="label__inline">Remember me</label>
                </div>
            </div>
        </div>
    </form>
</main>
</body>

</html>