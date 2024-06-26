<?php
session_start();
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Db.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Schedules.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/users/User.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/users/Manager.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Task.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Report.php");

if ($_SESSION["id"]) {
    $managerInfo = Manager::getManagerById($_SESSION["id"]);
} else {
    header("Location: login.php");
    exit();
}

$reportData = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $reportType = $_POST['report_type'];
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];
    $userId = $_POST['user_id'] ?? null;
    $taskId = $_POST['task_id'] ?? null;

    try {
        $reportData = Report::generateReport($reportType, $startDate, $endDate, $userId, $taskId);
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Reports</title>
    <link rel="stylesheet" href="../../../reset.css">
    <link rel="stylesheet" href="../../../shared.css">
    <link rel="stylesheet" href="managerReport.css">
</head>

<body>
<?php include_once("../../../components/headerManager.inc.php"); ?>
    <h1>Generate Reports</h1>
    <?php if (isset($error)) : ?>
        <p><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="POST">
        <label for="report_type">Report Type:</label>
        <select name="report_type" id="report_type" required>
            <option value="hoursWorked">Total Hours Worked</option>
            <option value="hoursOvertime">Overtime Hours</option>
            <option value="sickTime">Sick Time</option>
            <option value="timeOff">Time Off</option>
        </select>
        <label for="start_date">Start Date:</label>
        <input type="date" name="start_date" id="start_date" required>
        <label for="end_date">End Date:</label>
        <input type="date" name="end_date" id="end_date" required>
        <label for="user_id">User (if applicable):</label>
        <select name="user_id" id="user_id">
            <option value="">Select User</option>
            <?php foreach (User::getUsersByLocationAndRequests($managerInfo["location"]) as $user) : ?>
                <option value="<?php echo $user["id"]; ?>"><?php echo $user['username']; ?></option>
            <?php endforeach; ?>
        </select>
        <label for="task_id">Task Type (if applicable):</label>
        <select name="task_id" id="task_id">
            <option value="">Select Task Type</option>
            <?php foreach (Task::getTasks() as $task) : ?>
                <option value="<?php echo $task["id"]; ?>"><?php echo $task['name']; ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Generate</button>
    </form>

    <?php if (!empty($reportData)) : ?>
        <h2>Report Results</h2>
        <table border="1">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Task Name</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <?php if ($reportType === 'hoursWorked') : ?>
                        <th>Total Hours</th>
                    <?php elseif ($reportType === 'sickTime') : ?>
                        <th>Sick Hours</th>
                    <?php elseif ($reportType === 'timeOff') : ?>
                        <th>Time Off Hours</th>
                    <?php endif; ?>
                    <?php if ($reportType === 'hoursOvertime') : ?>
                        <th>Overtime Hours</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reportData as $row) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                        <td><?php echo htmlspecialchars($row['task_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['start_time']); ?></td>
                        <td><?php echo htmlspecialchars($row['end_time']); ?></td>
                        <td>
                            <?php if ($reportType === 'hoursWorked') : ?>
                                <?php echo htmlspecialchars($row['total_hours']); ?>
                            <?php elseif ($reportType === 'sickTime') : ?>
                                <?php echo htmlspecialchars($row['sick_hours']); ?>
                            <?php elseif ($reportType === 'timeOff') : ?>
                                <?php echo htmlspecialchars($row['time_off_hours']); ?>
                            <?php elseif ($reportType === 'hoursOvertime') : ?>
                                <?php echo htmlspecialchars($row['overtime_hours']); ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>

</html>