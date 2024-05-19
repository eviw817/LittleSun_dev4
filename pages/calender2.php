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
}

if ($_SESSION["id"]) {
    $user = User::getUserById($_SESSION["id"]);
    $events = Schedules::getShiftsById($user['id'], new DateTime());
} else {
    echo "Error: Session is invalid, please log-in again";
}

// Fetch schedule
$schedules = Schedules::getSchedules();

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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendar</title>
    <link rel="stylesheet" href="calender.css">

</head>

<body>
    <h1>Assign Task</h1>
    <?php if ($message) : ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>
    <form method="POST">
        <label for="user_id">User:</label>
        <select name="user_id" id="user_id">
            <option value="<?php echo $user['id']; ?>"><?php echo $user['username']; ?></option>
        </select>
        <label for="task_id">Task:</label>
        <select name="task_id" id="task_id" required>
            <?php foreach ($tasks as $task) : ?>
                <option value="<?php echo $task['id']; ?>"><?php echo $task['name']; ?></option>
            <?php endforeach; ?>
        </select>
        <label for="hub_id">Hub:</label>
        <select name="hub_id" id="hub_id" required>
            <?php foreach ($hubs as $hub) : ?>
                <option value="<?php echo $hub['id']; ?>"><?php echo $hub['name']; ?></option>
            <?php endforeach; ?>
        </select>
        <label for="schedule_date">Schedule Date:</label>
        <input type="date" name="schedule_date" id="schedule_date" required>

        <label for="start_time">Start Time:</label>
        <select name="start_time" id="start_time" required>
            <?php for ($i = 8; $i <= 19; $i++) : ?>
                <?php $time = sprintf("%02d:00", $i); ?>
                <option value="<?php echo $time; ?>"><?php echo $time; ?></option>
                <?php $time = sprintf("%02d:30", $i); ?>
                <option value="<?php echo $time; ?>"><?php echo $time; ?></option>
            <?php endfor; ?>
        </select>
        <label for="end_time">End Time:</label>
        <select name="end_time" id="end_time" required>
            <?php for ($i = 8; $i <= 19; $i++) : ?>
                <?php $time = sprintf("%02d:00", $i); ?>
                <option value="<?php echo $time; ?>"><?php echo $time; ?></option>
                <?php $time = sprintf("%02d:30", $i); ?>
                <option value="<?php echo $time; ?>"><?php echo $time; ?></option>
            <?php endfor ?>
        </select>
        <button type="submit" name="assign">Assign</button>
    </form>

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
                        <?php foreach ($events as $schedule) : ?>
                            <?php
                            $scheduleDate = new DateTime($schedule['schedule_date']);
                            if ($scheduleDate->format('Y-m-d') === $day) :
                                $startTime = strtotime($schedule['startTime']);
                                $endTime = strtotime($schedule['endTime']);

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
                                <div class="event" style="top: <?php echo $top; ?>px; height: <?php echo $height; ?>px;">
                                    <?php echo $schedule['task_name']; ?><br><br>
                                    <?php echo $schedule['user_name']; ?><br><br>
                                    <?php echo $schedule['startTime']; ?><br>
                                    <?php echo $schedule['endTime']; ?>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

    <?php elseif ($view === 'weekly') : ?>
        <div>
            <div style="margin-right: 20px;">
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
                                $startTime = strtotime($schedule['startTime']);
                                $endTime = strtotime($schedule['endTime']);

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
                                <div class="event" style="top: <?php echo $top; ?>px; height: <?php echo $height; ?>px; margin-top: 10px; margin-left: -10px; padding-right:100px;">
                                    <?php echo $schedule['task_name']; ?><br><br>
                                    <?php echo $schedule['user_name']; ?><br><br>
                                    <?php echo $schedule['startTime']; ?><br>
                                    <?php echo $schedule['endTime']; ?>
                                </div>
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
            $firstDayOfWeek = $currentDate->format('N'); // 1: Monday, 7: Sunday

            // Output empty cells for days before the first day of the month
            for ($i = 1; $i < $firstDayOfWeek; $i++) {
                echo '<div class="empty-day"></div>';
            }

            // Output the days of the month
            for ($day = 1; $day <= $daysInMonth; $day++) {
                $currentDate->setDate($year, $month, $day);
                $currentDayOfWeek = $currentDate->format('N');
                echo '<div class="day">';
                echo '<em>' . $day . '</em>';

                // Add events for this day
                foreach ($schedules as $schedule) {
                    $scheduleDate = new DateTime($schedule['schedule_date']);
                    if ($scheduleDate->format('Y-m-d') === $currentDate->format('Y-m-d')) {
                        echo '<div class="event"  style="margin-top: 10px; margin-left: -10px; padding-right:110px;">';
                        echo $schedule['task_name'] . '<br>';
                        echo $schedule['user_name'] . '<br>';
                        echo $schedule['startTime'] . '<br>';
                        echo $schedule['endTime'];
                        echo '</div>';
                    }
                }

                echo '</div>';
            }
            ?>
        </div>
    <?php endif; ?>
</body>

</html>
