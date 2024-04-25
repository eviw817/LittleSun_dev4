<?php

    include_once(__DIR__ . DIRECTORY_SEPARATOR . "/../classes/User.php");
    
   
    if(!empty($_POST)){

        $options = [
			'cost' => 15 //14² (dat is zoveel keer dat het gehashed wordt), dus je wilt dat het even duurt op in te loggen hoe moeilijker voor hacker
		];
 		$password = password_hash($_POST['password'], PASSWORD_DEFAULT, $options);
        try {
            $user = new User();
            $user->setUsername($_POST['username']);
            $user->setFirstName($_POST['firstName']);
            $user->setLastName($_POST['lastName']);
            $user->setEmail($_POST['email']);
            $user->setPassword($_POST['password']);
         
            if(isset($_POST["img"])){
                $user->setImage('data:image/' . $_FILES['img']['type'] . ';base64,' . base64_encode(file_get_contents($_FILES['img']['tmp_name'])));
            }
         
           $user->newUser();

            header("Location: user.php");
            exit();
        }
        catch(Exception $e){
          $error = $e->getMessage();
          
        }
    }



?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add user</title>
    <link rel="stylesheet" href="../css/general.css">
    
</head>
<body>
<?php include_once("../header.inc.php"); ?>
    <?php if(isset($error)): ?>
      <div class="text-red-500">Error: <?php echo $error; ?></div>
    <?php endif; ?> 

    <div class="form new_user">
		<form action="addUser.php" method="post" enctype="multipart/form-data">
			<h2 form__title>New user</h2>

            <div class="form__field">
            <div class="form__field">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username">
            </div>
            <div class="form__field">
                <label for="firstName">Firstname:</label>
                <input type="text" name="firstName" id="firstName">
            </div>

            <div class="form__field">
                <label for="lastName">Lastname:</label>
                <input type="text" name="lastName" id="lastName">
            </div>

            <div class="form__field">
                <label for="email">Email:</label>
                <input type="text" name="email" id="email">
            </div>

            <div class="form__field">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password">
            </div>
      
            <div class="form__field">
                <label for="img">Select image:</label>
                <input type="file" id="img" name="img" accept="image/jpg, png">
            </div>           
           
            <div class="form__field">
                <input type="submit" value="Save" class="btn-add">	
            </div>
		</form>
	</div>
</body>
</html>