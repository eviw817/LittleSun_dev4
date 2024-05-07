<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../../reset.css">
    <link rel="stylesheet" href="../../shared.css">
    <link rel="stylesheet" href="./dashboard.css">
    
</head>
<body>
    <?php include_once("../../components/headerAdmin.inc.php"); ?>

    <main>
        <h1>Admin Dashboard</h1>

        <section>
            
            <a class="link" href="../locations/locationList.php">Hub Locations</a>

            <a class="link" href="../managers/managerList.php">Hub Managers</a>

            <a class="link" href="../tasks/taskList.php">Task list</a>


        </section>

    </main>
</body>
</html>