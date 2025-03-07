<?
namespace DB;

interface DateRepository {
    public function saveMonth(int $month);
    public function findMonth(int $month): ?string;
}

?>