<?php
    include_once(__DIR__ . DIRECTORY_SEPARATOR . "/../../classes/HubLocation.php");
    
   

    if(!empty($_POST)){
        try {
            $location = new HubLocation();
            $location -> setName($_POST['name']);
            $location -> setStreet($_POST['street']);
            $location -> setStreetnumber($_POST['streetNumber']);
            $location -> setCity($_POST['city']);
            $location -> setCountry($_POST['country']);
            $location -> setPostalcode($_POST['postalCode']);
            //var_dump($location);
            $location->newLocation();
       
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
    <title>Add location</title>
</head>
<body>
<div class="form add_location">
        <?php if(isset($error)): ?>
        <div class="text-red-500">Error: <?php echo $error; ?></div>
        <?php endif; ?> 

		<form action="addLocation.php" method="post">
			<h2 form__title>New location</h2>

            <div class="form__field">
                <label for="name">Name</label>
                <input type="text" name="name">
            </div>
            <div class="form__field">
                <label for="street">Street</label>
                <input type="text" name="street">
            </div>
            <div class="form__field">
                <label for="streetnumber">Streetnumber</label>
                <input type="text" name="streetNumber">
            </div>
            <div class="form__field">
                <label for="city">City</label>
                <input type="text" name="city">
            </div>
            <div class="form__field">
                <label for="country">Country</label>
                <input type="text" name="country">
            </div>
            <div class="form__field">
                <label for="postalcode">Postalcode</label>
                <input type="text" name="postalCode">
            </div>
           
		</form>
        <button onclick="window.location.href='hubLocation.php'" class="btn-save">Save</button>	
	</div>
</body>
</html>