<?php
include_once(__DIR__ . DIRECTORY_SEPARATOR . "Db.php");

class Calendar
{
    private $events = [];
    private $weekStart = 0;

    public function addEvent($startTime, $endTime)
    {
        $this->events[] = [
            "startTime" => $startTime,
            "endTime" => $endTime
        ];
    }

    public function useMondayStartingDate()
    {
        $this->weekStart = 1;
    }

    public function getWeekStart()
    {
        return $this->weekStart;
    }

    public function getWeek()
    {
        $daysOfWeek = [];
        $weekStart = $this->getWeekStart();
        $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

        for ($i = $weekStart; $i < $weekStart + 7; $i++) {
            $dayIndex = $i % 7;
            $daysOfWeek[] = $days[$dayIndex];
        }

        return $daysOfWeek;
    }

    public function getEvents($day)
    {
        $events = [];
        foreach ($this->events as $event) {
            $events[] = [
                "startTime" => $event["startTime"],
                "endTime" => $event["endTime"],
            ];
        }
        return $events;
    }

    public function getCurrentDate()
    {
        return date('Y-m-d');
    }
}
