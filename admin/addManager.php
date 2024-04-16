<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add managers</title>
</head>
<body>
    <div class="form new_manager">
		<form action="" method="post">
			<h2 form__title>New hub manager</h2>

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
                <input type="submit" value="Reset" class="btn-reset">	
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
                <input type="submit" value="Add" class="btn-add">	
            </div>
		</form>
	</div>
</body>
</html>