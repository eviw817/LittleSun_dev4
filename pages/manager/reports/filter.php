<?php
session_start();
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Db.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/users/User.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/location.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/task.php");

// Database connectie
$conn = Db::getConnection();

// dropdown-gegevens
$users = User::getName();
$locations = Location::getLocationName();
$tasks = Task::getTasks();

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Report</title>
    <link rel="stylesheet" href="../../../reset.css">
    <link rel="stylesheet" href="../../../shared.css">
    <link rel="stylesheet" href="./filter1.css">
</head>
<body>
<?php include_once("../../../components/headerManager.inc.php"); ?>
<div class="container">
    <h1>Generate Report</h1>
    <form action="filter.php" method="post">
        <div class="form-group">
            <label for="user">User:</label>
            <select id="user" name="user">
                <option value="">Select User</option>
                <!-- gebruikersopties -->
                <?php foreach ($users as $user): ?>
                    <option value="<?= htmlspecialchars($user['id']) ?>"><?= htmlspecialchars($user['firstName'] . ' ' . $user['lastName']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="location">Location:</label>
            <select id="location" name="location">
                <option value="">Select Location</option>
                <!-- locatieopties -->
                <?php foreach ($locations as $loc): ?>
                    <option value="<?= htmlspecialchars($loc['id']) ?>"><?= htmlspecialchars($loc['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="task_type">Task Type:</label>
            <select id="task_type" name="task_type">
                <option value="">Select Task Type</option>
                <!-- taaktypeopties -->
                <?php foreach ($tasks as $task): ?>
                    <option value="<?= htmlspecialchars($task['id']) ?>"><?= htmlspecialchars($task['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="date_from">Date From:</label>
            <input type="date" id="date_from" name="date_from">
        </div>
        <div class="form-group">
            <label for="date_to">Date To:</label>
            <input type="date" id="date_to" name="date_to">
        </div>
        <button type="submit">Generate Report</button>
    </form>
</div>

<div class="container">
    <h2>Report Results</h2>
    <table>
            <th>User</th>
            <th>Location</th>
            <th>Task Type</th>
            <th>Hours</th>
            <th>Date</th>
        </tr>
        <!-- Resultaten van het rapport -->
    </table>
</div>
<div class="container">No results found.</div>
</body>
</html>
