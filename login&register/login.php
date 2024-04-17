<?php

if (isset($_GET["choice"])) {
    $choiceMade = $_GET["choice"];
} else {
    $choiceMade = "user";
};

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="loginStylesheet.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@700&family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
    <title>Login</title>
</head>

<body>

    <a href="choiceLogin.php" class="button">Go back to choice page</a>

    <form action="" method="post">
        <h2 form__title>Hello <?php echo $choiceMade ?>, please log in</h2>

        <div class="full__form">
            <div class="form__field">
                <label for="Email">Email</label>
                <input id="email" type="text" name="email">
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

</body>

</html>