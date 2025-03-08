<?
namespace DB;

interface DateRepository {
    public function saveMonth(int $monthNumber, string $monthName);
    public function findHolidays(int $month, int $countryCode);
    public function findHolidaysDay(int $month, int $countryCode, int $day);
}

?>