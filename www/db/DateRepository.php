<?
namespace DB;

interface DateRepository {
    public function saveMonth(int $monthNumber, string $monthName);
    public function findHolidays(int $month, string $countryCode);
    public function findHolidaysDay(int $month, string $countryCode, int $day);
}

?>