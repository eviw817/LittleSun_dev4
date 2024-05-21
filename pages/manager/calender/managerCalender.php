<?php
session_start();
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Db.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Schedules.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/users/User.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/users/Manager.php");
include_once(__DIR__ . DIRECTORY_SEPARATOR . "../../../classes/Task.php");

if ($_SESSION["id"]) {
    $managerInfo = Manager::getManagerById($_SESSION["id"]);
    $schedules = Schedules::getShiftsById($managerInfo['location'], new DateTime());
} else {
    echo "Error: Session is invalid, please log-in again";
}

$tasks = Task::getTasks(); // Array van taken
$users = User::getAllUsers(); // Array van gebruikers
$hubs = Schedules::getHubs();
$timeSlots = range(8, 19); // 8am to 7pm

// Assign task
$message = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['assign'])) {
    $schedule = new Schedules($_POST['user_id'], $_POST['task_id'], $managerInfo['location'], $_POST['schedule_date'], $_POST['start_time'], $_POST['end_time']);

    $result = $schedule->newShift();
    //$message = $result === true ? "Shift assigned successfully." : $result;

    // Opnieuw ophalen van schema's na het toewijzen van de nieuwe dienst
    $schedules = Schedules::getShiftsById($managerInfo['location'], new DateTime());

    $events = [];
    foreach ($schedules as $schedule) {
        $event = [
            'user_id' => $schedule['user_id'],
            'task_id' => $schedule['task_id'],
            'location_id' => $managerInfo['location'],
            'schedule_date' => $schedule['schedule_date'],
            'start_time' => $schedule['start_time'],
            'end_time' => $schedule['end_time']
        ];
        $events[] = $event;
    }

    // Sorteer de gebeurtenissen op datum
    usort($events, function ($a, $b) {
        return strtotime($a['schedule_date']) - strtotime($b['schedule_date']);
    });
}

function generateDaysForMonth($year, $month)
{
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
    usort($schedules, function ($a, $b) {
        return strtotime($a['schedule_date']) - strtotime($b['schedule_date']);
    });
}

?><!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendar manager</title>
    <link rel="stylesheet" href="../../../reset.css">
    <link rel="stylesheet" href="../../../shared.css">
    <link rel="stylesheet" href="./managerCalendar.css">
</head>

<body>
    <?php include_once("../../../components/headerManager.inc.php"); ?>
    <main>
        <div class="nav">
            <div class="agenda-info">
                <h1>Calender</h1>
                <h2><?php echo $managerInfo['name']; ?></h2>
                <a href="<?php date("d/m/y"); ?>">Today: <?php echo date("d/m/y"); ?></a>
            </div>
        </div>
        <?php if ($message) : ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>
        <form method="POST">
            <a class="newShift" href="#popup">New Shift</a>
            <div id="popup" class="popup">
                <div class="popup-content">
                    <h1>Assign Task</h1>
                    <a href="#" class="close">&times;</a>
                    <div class="hub">
                        <p>Hub:</p>
                        <p><?php echo $managerInfo['name']; ?></p>
                    </div>
                    <label for="user_id">User:</label>
                    <select name="user_id" id="user_id">
                        <?php foreach (User::getUsersByLocationAndRequests($managerInfo["location"]) as $user) : ?>
                            <option value="<?php echo $user["id"]; ?>"><?php echo $user['username']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label for="task_id">Task:</label>
                    <select name="task_id" id="task_id" required>
                        <?php foreach ($tasks as $task) : ?>
                            <option value="<?php echo $task['id']; ?>"><?php echo $task['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label for="schedule_date">Schedule date:</label>
                    <input type="date" name="schedule_date" id="schedule_date" required>
                    <label for="start_time">Start time:</label>
                    <select name="start_time" id="start_time" required>
                        <?php for ($i = 8; $i <= 19; $i++) : ?>
                            <?php $time = sprintf("%02d:00", $i); ?>
                            <option value="<?php echo $time; ?>"><?php echo $time; ?></option>
                            <?php $time = sprintf("%02d:30", $i); ?>
                            <option value="<?php echo $time; ?>"><?php echo $time; ?></option>
                        <?php endfor; ?>
                    </select>
                    <label for="end_time">End time:</label>
                    <select name="end_time" id="end_time" required>
                        <?php for ($i = 8; $i <= 19; $i++) : ?>
                            <?php $time = sprintf("%02d:00", $i); ?>
                            <option value="<?php echo $time; ?>"><?php echo $time; ?></option>
                            <?php $time = sprintf("%02d:30", $i); ?>
                            <option value="<?php echo $time; ?>"><?php echo $time; ?></option>
                        <?php endfor; ?>
                    </select>
                    <button class="button" type="submit" name="assign">Assign</button>
                </div>
            </div>
        </form>

        <div id="header">
            <a class="buttons" href="<?php echo $prevMonthUrl; ?>">&laquo; Previous</a>
            <h1><?php echo date('F Y', strtotime("$year-$month-01")); ?></h1>
            <a class="buttons" href="<?php echo $nextMonthUrl; ?>">Next &raquo;</a>
        </div>
        <div id="view-selector">
            <a class="buttons" href="?view=daily&year=<?php echo $year; ?>&month=<?php echo $month; ?>&day=<?php echo $day; ?>">Daily</a> |
            <a class="buttons" href="?view=weekly&year=<?php echo $year; ?>&month=<?php echo $month; ?>&day=<?php echo $day; ?>">Weekly</a> |
            <a class="buttons" href="?view=monthly&year=<?php echo $year; ?>&month=<?php echo $month; ?>">Monthly</a>
        </div>

        <?php if ($view === 'daily') : ?>
            <div class="day-header">
                <a class="buttons" href="<?php echo $prevDayUrl; ?>">&laquo; Previous Day</a>
                <?php echo date('l, F j, Y', strtotime("$year-$month-$day")); ?>
                <a class="buttons" href="<?php echo $nextDayUrl; ?>">Next Day &raquo;</a>
            </div>
            <div class="day">
                <div class="day-schedule">
                    <div class="time-column">
                        <?php for ($i = 8; $i <= 19; $i++) : ?>
                            <div class="time"><?php echo sprintf("%02d:00", $i); ?></div>
                        <?php endfor; ?>
                    </div>
                    <div class="shift-column">
                        <div class="day-column">
                            <?php foreach ($schedules as $schedule) : ?>
                                <?php
                                $scheduleDate = new DateTime($schedule['schedule_date']);
                                if ($scheduleDate->format('Y-m-d') === sprintf('%04d-%02d-%02d', $year, $month, $day)) :
                                    $startTime = strtotime($schedule['start_time']);
                                    $endTime = strtotime($schedule['end_time']);
                                    if ($endTime <= $startTime) {
                                        $endTime = strtotime('+1 hour', $startTime);
                                    }
                                    $startHour = date('H', $startTime);
                                    $startMinute = date('i', $startTime);
                                    $endHour = date('H', $endTime);
                                    $endMinute = date('i', $endTime);
                                    $top = (($startHour - 8) * 2 * 30) + ($startMinute / 30 * 30);
                                    $height = (($endHour - $startHour) * 2 + ($endMinute - $startMinute) / 30) * 30;
                                ?>
                                    <a class="event" href="managerEventInfo.php?id=<?php echo $schedule["id"] ?>" style="top: <?php echo $top; ?>px; height: <?php echo $height; ?>px;">
                                        <?php echo $schedule['name']; ?><br><br>
                                        <?php echo $schedule['username']; ?><br><br>
                                        <?php echo $schedule['start_time']; ?><br>
                                        <?php echo $schedule['end_time']; ?>
                                    </a>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

        <?php elseif ($view === 'weekly') : ?>
            <div>
                <div style="margin-right: 20px; margin-bottom: 20px;">
                    <a class="buttons" href="<?php echo $prevWeekUrl; ?>">Previous week</a>
                    <a class="buttons" href="<?php echo $nextWeekUrl; ?>">Next week</a>
                </div>
            </div>
            <div id="days">
                <?php
                $currentDay = clone $firstDayOfWeek;
                for ($i = 0; $i < 7; $i++) :
                ?>
                    <div class="day-header"><?php echo $currentDay->format('l, M j'); ?></div>
                <?php
                    $currentDay->modify('+1 day');
                endfor;
                ?>
            </div>
            <div class="flex">
                <div class="time-column">
                    <?php foreach (range(8, 19) as $hour) : ?>
                        <div class="time"><?php echo sprintf("%02d:00", $hour); ?></div>
                    <?php endforeach; ?>
                </div>
                <div id="week">
                    <?php
                    $currentDay = clone $firstDayOfWeek;
                    for ($i = 0; $i < 7; $i++) :
                    ?>
                        <div class="day-column">
                            <?php
                            foreach ($schedules as $schedule) :
                                $scheduleDate = new DateTime($schedule['schedule_date']);
                                if ($scheduleDate->format('Y-m-d') === $currentDay->format('Y-m-d')) :
                                    $startTime = strtotime($schedule['start_time']);
                                    $endTime = strtotime($schedule['end_time']);
                                    if ($endTime <= $startTime) {
                                        $endTime = strtotime('+1 hour', $startTime);
                                    }
                                    $startHour = date('H', $startTime);
                                    $startMinute = date('i', $startTime);
                                    $endHour = date('H', $endTime);
                                    $endMinute = date('i', $endTime);
                                    $top = (($startHour - 8) * 1.6 * 30) + ($startMinute / 30 * 30);
                                    $height = (($endHour - $startHour) * 1.6 + ($endMinute - $startMinute) / 30) * 30;
                            ?>
                                    <a class="event" href="managerEventInfo.php?id=<?php echo $schedule["id"] ?>" style="top: <?php echo $top; ?>px; height: <?php echo $height; ?>px;">
                                        <?php echo $schedule["name"]; ?><br><br>
                                        <?php echo $schedule['username']; ?><br><br>
                                        <?php echo $schedule['start_time']; ?><br>
                                        <?php echo $schedule['start_time']; ?>
                                    </a>
                            <?php
                                endif;
                            endforeach;
                            ?>
                        </div>
                    <?php
                        $currentDay->modify('+1 day');
                    endfor;
                    ?>
                </div>
            </div>

        <?php else : ?>
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
                $currentDate = new DateTime($year . '-' . $month . '-01');
                $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                $firstDayOfWeek = $currentDate->format('N');

                for ($i = 1; $i < $firstDayOfWeek; $i++) : ?>
                    <div class="empty-day"></div>
                <?php endfor;

                for ($day = 1; $day <= $daysInMonth; $day++) :
                    $currentDate->setDate($year, $month, $day);
                    $currentDayOfWeek = $currentDate->format('N'); ?>
                    <div class="day">
                        <em><?= $day ?></em>
                        <?php foreach ($schedules as $schedule) :
                            $scheduleDate = new DateTime($schedule['schedule_date']);
                            if ($scheduleDate->format('Y-m-d') === $currentDate->format('Y-m-d')) : ?>
                                <a class="event" href="managerEventInfo.php?id=<?= $schedule["id"] ?>" style="top: <?= $top ?>px; height: <?= $height ?>px;">
                                    <?= $schedule["name"] ?><br>
                                    <?= $schedule["username"] ?><br>
                                    <?= $schedule['start_time'] ?><br>
                                    <?= $schedule['end_time'] ?>
                                </a>
                        <?php endif;
                        endforeach; ?>
                    </div>
                <?php endfor; ?>
            </div>
        <?php endif; ?>
    </main>
</body>

</html>