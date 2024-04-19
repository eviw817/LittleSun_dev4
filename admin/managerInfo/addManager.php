<?php
    include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../classes/Hubmanagers.php");
    

    if(!empty($_POST)){
        try {
            $manager = new Hubmanagers();
            $manager->setFirstname($_POST['firstname']);
            $manager->setLastname($_POST['lastname']);
            $manager->setEmail($_POST['email']);
            $manager->setPassword($_POST['password']);
           // $manager->setLocation($_POST['location']);
         
        }
        catch(Exception $e){
          $error = $e->getMessage();
          
        }
    }

  
   //$allManagers = Hubmanagers::getAll();


?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add managers</title>
    <link rel="stylesheet" href="../css/algemeen.css">
</head>
<body>
    <?php if(isset($error)): ?>
      <div class="text-red-500">Error: <?php echo $error; ?></div>
    <?php endif; ?> 

    <div class="form new_manager">
		<form action="" method="post">
			<h2 form__title>New hub manager</h2>

            <div class="form__field">
                <label for="firstname">Firstname:</label>
                <input type="text" name="firstname">
            </div>
            <div class="form__field">
                <label for="lastname">Lastname:</label>
                <input type="text" name="lastname">
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
                <label for="profile_pic">Profile picture:</label>
                <input type="file" id="profile_pic" name="profile_pic" accept="image/*">
            </div>
            <div class="form__field">
                <label for="location">Choose location:</label>
                <select id="location" name="location">
                    <option value="location1">Location1</option>
                    <option value="location2">location2</option>
                    <option value="location3">location3</option>
                    <option value="location4">location4</option>
                </select>
            </div>
            

            <div class="form__field">
                <input type="submit" value="Add new manager" class="btn-add">	
            </div>
		</form>
	</div>
</body>
</html>