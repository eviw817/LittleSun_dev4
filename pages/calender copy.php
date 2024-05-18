<?php

session_start();
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../classes/Db.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../classes/Schedules.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../classes/users/User.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../classes/users/Manager.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../classes/Task.php");



$tasks = Schedules::getTasks(); // Array van taken
$hubs = Schedules::getHubs();
$timeSlots = range(8, 19); // 8am to 7pm

// Assign task
$message = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['assign'])) {
    $user_id = $_POST['user_id'];
    $task_id = $_POST['task_id'];
    $hub_id = $_POST['hub_id'];
    $schedule_date = $_POST['schedule_date'];
    $startTime = $_POST['start_time'];
    $endTime = $_POST['end_time'];

    $schedule = new Schedules($user_id, null, $task_id, null, $hub_id, null, $schedule_date, $startTime, $endTime);

    $result = $schedule->newShift();
    $message = $result === true ? "Shift assigned successfully." : $result;
    
    // Opnieuw ophalen van schema's na het toewijzen van de nieuwe dienst
    $schedules = Schedules::getSchedules();
    
    $events = [];
    foreach ($schedules as $schedule) {
        $event = [
            'user_name' => $schedule['user_name'],
            'task_name' => $schedule['task_name'],
            'location_name' => $schedule['location_name'],
            'schedule_date' => $schedule['schedule_date'],
            'startTime' => $schedule['startTime'],
            'endTime' => $schedule['endTime']
        ];
        $events[] = $event;
    }
    

// Sorteer de gebeurtenissen op datum
usort($events, function($a, $b) {
    return strtotime($a['schedule_date']) - strtotime($b['schedule_date']);
});
}

if($_SESSION["id"]){
    $managerInfo = Manager::getManagerById($_SESSION["id"]);
    $events = Schedules::getShiftsById($managerInfo['location'], new DateTime());
} else {
    echo "Error: Session is invalid, please log-in again";
}

// Fetch schedule
$schedules = Schedules::getSchedules();

function generateDaysForMonth($year, $month) {
    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
    $days = [];

    for ($day = 1; $day <= $daysInMonth; $day++) {
        $days[] = sprintf('%04d-%02d-%02d', $year, $month, $day);
    }
    return $days;
}

$view = isset($_GET['view']) ? $_GET['view'] : 'monthly';
$year = isset($_GET['year']) ? (int)$_GET['year'] : date('Y');
$month = isset($_GET['month']) ? (int)$_GET['month'] : date('m');
$day = isset($_GET['day']) ? (int)$_GET['day'] : date('j');
$firstDayOfWeek = (new DateTime("$year-$month-$day"))->modify('monday this week');
$lastDayOfWeek = (new DateTime("$year-$month-$day"))->modify('sunday this week');

$prevWeek = (clone $firstDayOfWeek)->modify('-1 week');
$nextWeek = (clone $firstDayOfWeek)->modify('+1 week');

$prevWeekUrl = "?view=weekly&year=" . $prevWeek->format('Y') . "&month=" . $prevWeek->format('m') . "&day=" . $prevWeek->format('d');
$nextWeekUrl = "?view=weekly&year=" . $nextWeek->format('Y') . "&month=" . $nextWeek->format('m') . "&day=" . $nextWeek->format('d');


$prevMonth = $month - 1;
$nextMonth = $month + 1;
$prevYear = $year;
$nextYear = $year;

if ($prevMonth == 0) {
    $prevMonth = 12;
    $prevYear--;
}

if ($nextMonth == 13) {
    $nextMonth = 1;
    $nextYear++;
}

$prevMonthUrl = "?view=$view&year=$prevYear&month=$prevMonth";
$nextMonthUrl = "?view=$view&year=$nextYear&month=$nextMonth";

$prevDay = $day - 1;
$nextDay = $day + 1;
$prevDayUrl = "?view=$view&year=$year&month=$month&day=$prevDay";
$nextDayUrl = "?view=$view&year=$year&month=$month&day=$nextDay";

$allDaysThisMonth = generateDaysForMonth($year, $month);

if ($view === 'daily') {
    // Sorteer $schedules op basis van de dag
    usort($schedules, function($a, $b) {
        return strtotime($a['schedule_date']) - strtotime($b['schedule_date']);
    });
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendar</title>
    <style>
    body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: #f4f4f4;
        }
        #header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 80%;
            max-width: 800px;
            padding: 20px;
            background-color: #fff;
            margin-top: 20px;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
        }
        #days, #month, #week, #day {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            width: 80%;
            max-width: 800px;
            background-color: #fff;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        #days div, #month div, #week div, #day div {
            padding: 10px;
            text-align: center;
        }
        #days div {
            font-weight: bold;
            background-color: #f0f0f0;
        }
        #month, #week, #day {
            border-collapse: collapse;
        }
        #month .day, #week .day, #day .day {
            border: 1px solid #ddd;
            height: 100px;
            display: flex;
            justify-content: flex-start;
            align-items: flex-start;
            position: relative;
        }
        #month .day:nth-child(7n+1), #week .day:nth-child(7n+1), #day .day:nth-child(7n+1) {
            border-left: 0;
        }
        #month .day:nth-child(-n+7), #week .day:nth-child(-n+7), #day .day:nth-child(-n+7) {
            border-top: 0;
        }
        .day em {
            font-style: normal;
            color: #666;
            position: absolute;
            top: 5px;
            left: 5px;
        }
        a {
            text-decoration: none;
            color: #007bff;
        }
        a:hover {
            text-decoration: underline;
        }
        h1 {
            margin: 0;
            font-size: 1.5em;
        }
        #view-selector {
            margin: 20px 0;
        }
        h1 {
            margin-top: 20px;
        }
        form {
            width: 300px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            margin-bottom: 20px;
        }
        label, select, input, button {
            margin-bottom: 10px;
            width: 100%;
        }
        table {
            width: 80%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
    

        #calendar-container {
    width: 90%;
    max-width: 1200px;
    background-color: #fff;
    box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
    margin-top: 20px;
    margin: 0; /* Add this line to reset margin */
    padding: 0; /* Add this line to reset padding */
    border: none; /* Add this line to remove border */
}

.calendar-header {
    display: grid;
    grid-template-columns: 90px repeat(7, 0.5fr);
    align-items: center;
    padding: 10px;
    border-bottom: 1px solid #ddd;
}

.calendar-days {
    display: grid;
    grid-template-columns: 90px repeat(7, 1fr);
    border-bottom: 1px solid #ddd;
}

#week{
    padding: 20px;
}

.day {
    text-align: center;
    padding: 10px;
    font-weight: bold;
    border-right: 1px solid #ddd;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
}

.day:last-child {
    border-right: none;
}

.calendar-body {
    display: grid;
    grid-template-columns: 99px repeat(7, 1fr);
    border-bottom: 1px solid #ddd;
}

.time-column {
    border-right: 1px solid #ddd;
    padding-top: 20px;
    padding-right: 20px;
    padding-left: 10px;
    text-align: right;
    position: relative;
}

.day-column {
    border-right: 1px solid #ddd;
    padding: 15px;
    position: relative;
    height: auto; /* Auto height */
}

.day-column:last-child {
    border-right: none;
}

.time {
    margin-bottom: 30px;
}

.event {
    background-color: #007bff;
    color: white;
    padding: 5px;
    margin-bottom: 5px;
    border-radius: 3px;
    position: absolute;
    width: calc(100% - 20px); /* Width of the event block */
    box-sizing: border-box; /* Include padding and border in width calculation */
}

    </style>
</head>
<body>
<h1>Assign Task</h1>
<?php if ($message): ?>
    <p><?php echo $message; ?></p>
<?php endif; ?>
<form method="POST">
    <label for="user_id">User:</label>
    <select name="user_id" id="user_id">
        <?php foreach (User::getUsersByLocationAndRequests($managerInfo["location"]) as $user) : ?>
            <option value="<?php echo $user["id"]; ?>"><?php echo $user['username']; ?></option>
        <?php endforeach; ?>
    </select>
    <label for="task_id">Task:</label>
    <select name="task_id" id="task_id" required>
        <?php foreach ($tasks as $task): ?>
            <option value="<?php echo $task['id']; ?>"><?php echo $task['name']; ?></option>
        <?php endforeach; ?>
    </select>
    <label for="hub_id">Hub:</label>
    <select name="hub_id" id="hub_id" required>
        <?php foreach ($hubs as $hub): ?>
            <option value="<?php echo $hub['id']; ?>"><?php echo $hub['name']; ?></option>
        <?php endforeach; ?>
    </select>
    <label for="schedule_date">Schedule Date:</label>
    <input type="date" name="schedule_date" id="schedule_date" required>

    <label for="start_time">Start Time:</label>
    <select name="start_time" id="start_time" required>
        <?php for($i = 8; $i <= 19; $i++): ?>
            <?php $time = sprintf("%02d:00", $i); ?>
            <option value="<?php echo $time; ?>"><?php echo $time; ?></option>
            <?php $time = sprintf("%02d:30", $i); ?>
            <option value="<?php echo $time; ?>"><?php echo $time; ?></option>
        <?php endfor; ?>
    </select>
    <label for="end_time">End Time:</label>
    <select name="end_time" id="end_time" required>
        <?php for($i = 8; $i <= 19; $i++): ?>
            <?php $time = sprintf("%02d:00", $i); ?>
            <option value="<?php echo $time; ?>"><?php echo $time; ?></option>
            <?php $time = sprintf("%02d:30", $i); ?>
            <option value="<?php echo $time; ?>"><?php echo $time; ?></option>
        <?php endfor; ?>
    </select>


    <button type="submit" name="assign">Assign</button>
</form>

<h1>Full Schedule</h1>
<table border="1">
    <thead>
    <tr>
        <th>User</th>
        <th>Task</th>
        <th>Hub</th>
        <th>Date</th>
        <th>Start Time</th>
        <th>End Time</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($schedules as $schedule): ?>
        <tr>
            <td><?php echo $schedule['user_name']; ?></td>
            <td><?php echo $schedule['task_name']; ?></td>
            <td><?php echo $schedule['location_name']; ?></td>
            <td><?php echo $schedule['schedule_date']; ?></td>
            <td><?php echo $schedule['startTime']; ?></td>
            <td><?php echo $schedule['endTime']; ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<div id="view-selector">
    <a href="?view=monthly">Monthly</a> |
    <a href="?view=weekly">Weekly</a> |
    <a href="?view=daily">Daily</a>
</div>
<div>
    <a href="<?php echo $prevWeekUrl; ?>">Previous Week</a>
    <a href="<?php echo $nextWeekUrl; ?>">Next Week</a>
</div>
<div id="calendar-container">
    <div class="calendar-header">
        <div class="time-column"></div>
        
        <?php
        $daysOfWeek = array("Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun");
        $currentDay = clone $firstDayOfWeek;
        foreach ($daysOfWeek as $day) {
            echo '<div class="day">' . $day . '<br>' . $currentDay->format('j') . '</div>';
            $currentDay->modify('+1 day');
        }
        ?>
    </div>
    <div class="calendar-body">
        <div class="time-column">
            <?php foreach (range(8, 19) as $hour): ?>
                <div class="time"><?php echo sprintf("%02d:00", $hour); ?></div>
            <?php endforeach; ?>
        </div>

        <?php
        $currentDay = clone $firstDayOfWeek;
        for ($dayIndex = 0; $dayIndex < 7; $dayIndex++) {
            echo '<div class="day-column">';
            foreach ($schedules as $schedule):
                if (isset($schedule['schedule_date']) && date('N', strtotime($schedule['schedule_date'])) == date('N', strtotime($currentDay->format('Y-m-d')))): ?>
                    <?php
                    $startTime = strtotime($schedule['startTime']);
                    $endTime = strtotime($schedule['endTime']);
                    $startHour = date('H', $startTime);
                    $startMinute = date('i', $startTime);
                    $endHour = date('H', $endTime);
                    $endMinute = date('i', $endTime);
                    $top = (($startHour - 8) * 2 * 30) + ($startMinute / 30 * 30); // Calculate top position
                    $height = (($endHour - $startHour) * 2 + ($endMinute - $startMinute) / 30) * 30; // Calculate height
                    ?>
                    <div class="event" style="top: <?php echo $top; ?>px; height: <?php echo $height; ?>px;">
                        <?php echo $schedule['task_name']; ?><br><br>
                        <?php echo $schedule['user_name']; ?><br>
                    </div>
                <?php endif;
            endforeach;
            echo '</div>'; // Verplaats de sluitende div-tag hier om de lus correct af te sluiten
            $currentDay->modify('+1 day');
        }
        ?>
    </div>
</div>

</body>
</html>
