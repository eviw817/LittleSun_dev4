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
         #week, #day {
            display: grid;
            grid-template-columns: repeat(7, 0.5fr);
            width: 100%;
            max-width: 860px;
            background-color: #fff;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        #month{
            display: grid;
            grid-template-columns: repeat(7, 0.5fr);
            width: 100%;
            max-width: 860px;
            background-color: #fff;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            margin-left: 70px;margin-left: 70px;
        }
        #days{
            display: grid;
            grid-template-columns: repeat(7, 3fr);
            width: 100%;
            max-width: 800px;
            background-color: #fff;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            padding: 10px;
            margin-left: 70px;
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
        width: 90%; /* You can adjust this value as needed */
        max-width: 1200px;
        background-color: #fff;
        box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
        margin-top: 20px;
        margin: 0; 
        padding: 0; 
        border: none;
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
    width: 95px;
}

.day-column:last-child {
    border-right: none;
}

.time {
    margin-bottom: 30px;
}

.event {
    background-color: #007bff;
    font-size: 17px;
    color: white;
    margin-bottom: 5px;
    border-radius: 3px;
    position: absolute;
    width: calc(100% - 20px); /* Width of the event block */
    box-sizing: border-box; /* Include padding and border in width calculation */
}

        .flex {
            display: flex;
            flex-direction: row;
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
<div id="header">
    <a href="<?php echo $prevMonthUrl; ?>">&laquo; Previous</a>
    <h1><?php echo date('F Y', strtotime("$year-$month-01")); ?></h1>
    <a href="<?php echo $nextMonthUrl; ?>">Next &raquo;</a>
</div>
<div id="view-selector">
    <a href="?view=daily&year=<?php echo $year; ?>&month=<?php echo $month; ?>&day=<?php echo $day; ?>">Daily</a> |
    <a href="?view=weekly&year=<?php echo $year; ?>&month=<?php echo $month; ?>&day=<?php echo $day; ?>">Weekly</a> |
    <a href="?view=monthly&year=<?php echo $year; ?>&month=<?php echo $month; ?>">Monthly</a>
</div>

<?php if ($view === 'daily'): ?>
<div>
    <a href="<?php echo $prevWeekUrl; ?>">Previous Week</a>
    <a href="<?php echo $nextWeekUrl; ?>">Next Week</a>
</div>
    <div id="day">
        <a href="<?php echo $prevDayUrl; ?>">&laquo; Previous</a>
        <div class="day"><?php echo date('l, F j, Y', strtotime("$year-$month-$day")); ?></div>
        <a href="<?php echo $nextDayUrl; ?>">Next &raquo;</a>
    </div>
    <div id="day-schedule">
        <div class="hours">
            <?php for ($i = 8; $i <= 19; $i++): ?>
                <div><?php echo sprintf("%02d:00", $i); ?></div>
                <div><?php echo sprintf("%02d:30", $i); ?></div>
            <?php endfor; ?>
        </div>
        <div id="day-calendar">
            <?php foreach ($allDaysThisMonth as $day): ?>
                <div class="day">
                    <?php if ($day): ?>
                        <em><?php echo date('j', strtotime($day)); ?></em>
                        <!-- Voeg hier de gebeurtenissen toe voor deze dag -->
                        <?php foreach ($schedules as $schedule): ?>
                            <?php if (isset($schedule['schedule_date']) && date('Y-m-d', strtotime($schedule['schedule_date'])) === $day): ?>
                                <?php
                                // Bereken de toppositie en hoogte van het blok op basis van start- en eindtijd
                                $startTime = strtotime($schedule['startTime']);
                                $endTime = strtotime($schedule['endTime']);
                                $top = ($startTime - strtotime("08:00:00")) / 1800 * 20; // 1800 seconden in een half uur, 20 pixels per half uur
                                $height = ($endTime - $startTime) / 1800 * 20; // Hoogte van het blok in pixels
                                ?>
                                <div class="event" style="top: <?php echo $top; ?>px; height: <?php echo $height; ?>px;">
                                   <?php echo $schedule['task_name']; ?><br>
                                   <?php echo $schedule['user_name']; ?><br>
                                    
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php elseif ($view === 'weekly'): ?>
    <div>
        <div style="margin-right: 20px;">
            <a href="<?php echo $prevWeekUrl; ?>">Vorige week</a>
            <a href="<?php echo $nextWeekUrl; ?>">Volgende week</a>
        </div>
    </div>
    <div id="days">
        <?php
        $currentDay = clone $firstDayOfWeek;
        for ($i = 0; $i < 7; $i++):
            ?>
            <div class="day-header"><?php echo $currentDay->format('l, M j'); ?></div>
            <?php
            $currentDay->modify('+1 day');
        endfor;
        ?>
    </div>
    <div class="flex">
        <div class="time-column">
            <?php foreach (range(8, 19) as $hour): ?>
                <div class="time"><?php echo sprintf("%02d:00", $hour); ?></div>
            <?php endforeach; ?>
        </div>
        <div id="week">
    <?php
    $currentDay = clone $firstDayOfWeek;
    for ($i = 0; $i < 7; $i++):
    ?>
    <div class="day-column">
        <?php
        foreach ($schedules as $schedule):
            if (isset($schedule['schedule_date']) && date('N', strtotime($schedule['schedule_date'])) == date('N', strtotime($currentDay->format('Y-m-d')))):
                $startTime = strtotime($schedule['startTime']);
                $endTime = strtotime($schedule['endTime']);
        
                // Zorg ervoor dat de eindtijd minstens één uur na de starttijd is
                if ($endTime <= $startTime) {
                    $endTime = strtotime('+1 hour', $startTime);
                }
        
                $startHour = date('H', $startTime);
                $startMinute = date('i', $startTime);
                $endHour = date('H', $endTime);
                $endMinute = date('i', $endTime);
        
                $top = (($startHour - 8) * 2 * 30) + ($startMinute / 30 * 30); // Bereken de bovenste positie
                $height = (($endHour - $startHour) * 2 + ($endMinute - $startMinute) / 30) * 30; // Bereken de hoogte
                ?>
                <div class="event" style="top: <?php echo $top; ?>px; height: <?php echo $height; ?>px;">
                    <?php echo $schedule['task_name']; ?><br><br>
                    <?php echo $schedule['user_name']; ?><br>
                </div>
            <?php endif;
        endforeach;
        
        ?>
    </div>
    <?php
    $currentDay->modify('+1 day');
    endfor;
    ?>
</div>

    </div>


<?php else: ?>
        <div id="days">
    <div>Mon</div>
    <div>Tue</div>
    <div>Wed</div>
    <div>Thu</div>
    <div>Fri</div>
    <div>Sat</div>
    <div>Sun</div>
</div>
<div id="month">
    <?php
    foreach ($allDaysThisMonth as $day): ?>
        <div class="day">
            <?php if ($day): ?>
                <em><?php echo date('j', strtotime($day)); ?></em>

                <!-- Voeg hier de gebeurtenissen toe voor deze dag -->
                <?php foreach ($schedules as $schedule): ?>
                    <?php if (isset($schedule['schedule_date']) && date('Y-m-d', strtotime($schedule['schedule_date'])) === $day): ?>
                        <div class="event" style="padding-top: 20px;">
                                <?php echo $schedule['task_name']; ?><br>
                                <?php echo $schedule['user_name']; ?><br>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>

            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>
</body>
</html>