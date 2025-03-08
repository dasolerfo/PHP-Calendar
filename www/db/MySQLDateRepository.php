<?php 
    namespace DB;

    use PDO;
    use PDOException;
    
    class MySQLDateRepository implements DateRepository {
        private $pdo;

        public function __construct() {
            $this->pdo = Database::getInstance()->getConnection();
        }
    
        public function findMonth(int $month): ?string{
            return null;
        }

        public function findHolidays(int $month, int $countryCode) {
            $stmt = $this->pdo->prepare('
                SELECT holiday_name, holiday_description
                FROM Day WHERE month_number = :month AND countryCode = :countryCode');
            $stmt->bindParam(':month', $month, PDO::PARAM_INT);
            $stmt->bindParam(':countryCode', $countryCode, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function findHolidaysDay(int $month, int $countryCode, int $day) {
            $stmt = $this->pdo->prepare('
                SELECT holiday_name, holiday_description
                FROM Day WHERE month_number = :month AND countryCode = :countryCode AND day_number = :day');
            $stmt->bindParam(':month', $month, PDO::PARAM_INT);
            $stmt->bindParam(':countryCode', $countryCode, PDO::PARAM_STR);
            $stmt->bindParam(':day', $day, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function saveMonth(int $monthNumber, string $monthName): bool {
            $stmt = $this->pdo->prepare('
                INSERT INTO Month (month_number, month_name) VALUES (:month_number, :month_name)');
            $stmt->bindParam(':month_number', $monthNumber, PDO::PARAM_INT);
            $stmt->bindParam(':month_name', $monthName, PDO::PARAM_STR);
            $stmt->execute();
            return true;
            
        }

    }

    

?>