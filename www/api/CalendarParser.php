<?php
namespace API;

use Model\Date;
use Model\Holiday;

class CalendarParser {

    public array $calendarDates = [];

    public function __construct() {
        for ($i = 0; $i < 6; $i++) {
            for ($j = 0; $j < 7; $j++) {
                $this->calendarDates[$i][$j] = new Date(0);
            }
        }
    }

    public static function DateParser(mixed $json, int $month, int $year) {
        $firstday = sprintf("%04d-%02d-01", $year, $month);
        $columna = date('w', strtotime($firstday)) - 1;

        $calendar = new self();

        foreach ($json["response"]["holidays"] as $holiday) {
            $parsedHoliday = $calendar->HolidayParser($holiday);
            $day = (int) date('d', strtotime($holiday["date"]["iso"]));

            $fila = intdiv(($day - 1) + $columna, 7);
            $setmana = (($day - 1) + $columna) % 7;

            $calendar->calendarDates[$fila][$setmana]->holidays[] = $parsedHoliday;
        }

        return $calendar->calendarDates; 
    }

    private function HolidayParser(array $jsonHoliday): Holiday {
        return new Holiday(
            $jsonHoliday["name"],
            $jsonHoliday["description"] ?? '',
            $jsonHoliday["type"],
            $jsonHoliday["date"]["iso"]
        );
    }
}
?>