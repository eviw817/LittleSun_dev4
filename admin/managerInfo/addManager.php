<?php
    include_once(__DIR__ . DIRECTORY_SEPARATOR . "/../../classes/HubManagers.php");
    
    function getLocation(){
        $conn = Db::getConnection();
        $statement = $conn->prepare("SELECT name FROM users");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
   
    if(!empty($_POST)){
        try {
            $manager = new HubManagers();
            $manager->setUsername($_POST['username']);
            $manager->setEmail($_POST['email']);
            $manager->setPassword($_POST['password']);
            $manager->setRole($_POST['role']);
            // $manager->setLocation($_POST['location']);
            $manager->setFirstName($_POST['firstName']);
            $manager->setLastName($_POST['lastName']);

         
           $manager->newManager();

           header("Location: hubManagers.php");
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
    <title>Add managers</title>
    <link rel="stylesheet" href="../css/algemeen.css">
</head>
<body>
    <?php if(isset($error)): ?>
      <div class="text-red-500">Error: <?php echo $error; ?></div>
    <?php endif; ?> 

    <div class="form new_manager">
		<form action="addManager.php" method="post">
			<h2 form__title>New hub manager</h2>

            <div class="form__field">
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
                <input type="submit" value="Add new manager" class="btn-add">	
            </div>
		</form>
	</div>
</body>
</html>