<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add location</title>
</head>
<body>
<div class="form add_location">
		<form action="" method="post">
			<h2 form__title>New location</h2>

            <div class="form__field">
                <label for="Name_location">Name</label>
                <input type="text" name="name">
            </div>

            <div class="form__field">
                <input type="submit" value="Save" class="btn-save" onclick="window.location.href='hubLocation.php'">	
            </div>
		</form>
	</div>
</body>
</html>