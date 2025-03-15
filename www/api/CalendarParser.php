<?php
namespace API;

use Model\Date;
use Model\Holiday;

class CalendarParser {

    public array $calendarDates = [];

    public function __construct($offset, $lastDay, $year, $month) {
        
        $calendarDay = $lastDay - ($offset - 1);
    
        $active = false;
        if ($offset == 0){
            $calendarDay = 1;
            $active = TRUE;
            

            $lastDay = date('t', strtotime("$year-$month-01"));
        }


        for ($i = 0; $i < 6; $i++) {
            if ((!$active && $calendarDay < 7)) {
                
                continue;
            }

            for ($j = 0; $j < 7; $j++) {
                
                $this->calendarDates[$i][$j] = new Date($calendarDay, $active);
                $calendarDay++;
                if ($calendarDay > $lastDay){

                    $calendarDay = 1;
                    $active = $active == true ? false : true;
                    $lastDay = date('t', strtotime("$year-$month-01"));
                    if (!$active) break;
                }
            }
        }
    }

    public static function DateParserJson(mixed $json, int $month, int $year) {

        $firstday = sprintf("%04d-%02d-01", $year, $month);
        $columna = date('w', strtotime($firstday)) -1;
        $columna = $columna == -1 ? 6 : $columna;
        $lastPreviousDay = date('t', strtotime("$year-$month-01 -1 day"));

        $calendar = new self($columna, $lastPreviousDay, $year, $month);


        foreach ($json['response']['holidays'] as $holiday) { 
            $parsedHoliday = $calendar->HolidayParser($holiday);
            $day = (int) date('d', strtotime($holiday["date"]["iso"]));

            $fila = intdiv(($day - 1) + $columna, 7);
            $setmana = (($day - 1) + $columna) % 7;

            $calendar->calendarDates[$fila][$setmana]->holidays[] = $parsedHoliday;
            //$calendar->calendarDates[$fila][$setmana]->active = true;
        }

        return $calendar->calendarDates; 
    }

    private function HolidayParser(array $jsonHoliday): Holiday {
        return new Holiday(
            $jsonHoliday["date"]["iso"],
            $jsonHoliday["name"],
            $jsonHoliday["description"] ?? '',
            $jsonHoliday["type"]
        );
    }
    private function HolidayParserSQL(array $sqlHoliday): Holiday {
        return new Holiday(
           sprintf("%04d-%02d-%02d", 2025, $sqlHoliday["month_number"], $sqlHoliday["day_number"]) ,
            $sqlHoliday["holiday_name"],
            $sqlHoliday["holiday_description"] ?? '',
            ''
        );
    }

    public static function DateParserSQL($sqlResult, int $month, int $year) {

        $firstday = sprintf("%04d-%02d-01", $year, $month);
        
        $columna = date('w', strtotime($firstday)) - 1;
        
        $columna = $columna == -1 ? 6 : $columna;
        

        $lastPreviousDay = date('t', strtotime("$year-$month-01 -1 day"));

        $calendar = new self($columna, $lastPreviousDay, $year, $month);


        foreach ($sqlResult as $holiday) { 
           
            $parsedHoliday = $calendar->HolidayParserSQL($holiday);
            
            $day = (int) date('d', strtotime( sprintf("%04d-%02d-%02d", 2025, $holiday["month_number"], $holiday["day_number"])));
            $fila = intdiv(($day - 1) + $columna, 7);
            $setmana = (($day - 1) + $columna) % 7;

            $calendar->calendarDates[$fila][$setmana]->holidays[] = $parsedHoliday;
            //$calendar->calendarDates[$fila][$setmana]->active = true;
        }

        return $calendar->calendarDates; 
    }


}
?>