<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit hub manager</title>
    <link rel="stylesheet" href="../css/algemeen.css">
</head>
<body>
    <div class="form edit_manager">
		<form action="" method="post">
			<h2 form__title>Edit hub manager</h2>

            <div class="form__field">
                <label for="Name">Name</label>
                <input type="text" name="name">
            </div>
            <div class="form__field">
                <label for="Email">Email</label>
                <input type="text" name="email">
            </div>
            <div class="form__field">
                <label for="Password">Password</label>
                <input type="password" name="password">
            </div>
           
            <div class="form__field">
                <label for="location">Choose location:</label>
                <select id="location" name="location">
                    <option value="location1">Location1</option>
                    <option value="location2">Location2</option>
                    <option value="location3">Location3</option>
                    <option value="location4">Location4</option>
                </select>
            </div>
            

            <div class="form__field">
                <input type="submit" value="Save" class="btn-save" onclick="window.location.href='manager.php'">	
            </div>
		</form>
	</div>
</body>
</html>