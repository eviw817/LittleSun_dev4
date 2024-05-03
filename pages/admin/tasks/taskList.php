<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task List</title>
</head>

<body>
    <h1>Tasks</h1>
        <section>
            <ul class="taskList">
                <?php foreach (getLocationName() as $location) : ?>
                    <a href="location.php?id=<?php echo $location["id"] ?>" class="locationDetail">
                        <li><?php echo $location['name']; ?>
                        </li>
                    </a>
                <?php endforeach; ?>
            </ul>
        </section>

    <div class="button fixed-position">
        <a href="removeLocation.php">Add or remove locations</a>
    </div>

</body>

</html>