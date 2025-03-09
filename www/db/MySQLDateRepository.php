<?php 
    namespace DB;

    use PDO;
    use Model\Holiday;
    use PDOException;
    
    class MySQLDateRepository implements DateRepository {
        private $pdo;

        public function __construct() {
            $this->pdo = Database::getInstance()->getConnection();
        }
    
        public function findMonth(int $month): ?string {
            $sql = "SELECT month_name FROM Month WHERE month_number = :month";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':month', $month, PDO::PARAM_INT);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $result ? $result['month_name'] : null;
        }

        public function findHolidays(int $month, string $countryCode) {
            $stmt = $this->pdo->prepare('
                SELECT *
                FROM Day WHERE month_number = :month AND countryCode = :countryCode');
            $stmt->bindParam(':month', $month, PDO::PARAM_INT);
            $stmt->bindParam(':countryCode', $countryCode, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function findHolidaysDay(int $month, string $countryCode, int $day) {
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
            echo "hula";
            $stmt = $this->pdo->prepare('
                INSERT INTO Month (month_number, month_name) VALUES (:month_number, :month_name)');
            $stmt->bindParam(':month_number', $monthNumber, PDO::PARAM_INT);
            $stmt->bindParam(':month_name', $monthName, PDO::PARAM_STR);
            echo $monthNumber . ' '. $monthName;
            $stmt->execute();
            return true;
        }

        public function saveDay(int $dayNumber, int $monthNumber, string $countryCode, string $holidayName, string $holidayDescription): bool {
            $sql = "INSERT INTO Day (day_number, month_number, countryCode, holiday_name, holiday_description) 
                    VALUES (:dayNumber, :monthNumber, :countryCode, :holidayName, :holidayDescription)";
            
            $stmt = $this->pdo->prepare($sql);
            
            return $stmt->execute([
                ':dayNumber' => $dayNumber,
                ':monthNumber' => $monthNumber,
                ':countryCode' => $countryCode,
                ':holidayName' => $holidayName,
                ':holidayDescription' => $holidayDescription
            ]);
        }



        public function saveHolidays($holidays, $country, $month, $monthName){
            echo 'viva el rey';
            if (!($this->findMonth($month))){
                echo 'paw paw';
                $this->saveMonth($month, $monthName);
            }
            echo 'osea hello';
            foreach ($holidays['response']['holidays'] as $holiday) { 
                $parsedHoliday = $this->HolidayParser($holiday);
            
                $this->saveDay(date('d', strtotime($parsedHoliday->date)), $month, $country, $parsedHoliday->name, $parsedHoliday->description);
                
            }
        }

        private function HolidayParser(array $jsonHoliday): Holiday {
            return new Holiday(
                $jsonHoliday["date"]["iso"],
                $jsonHoliday["name"],
                $jsonHoliday["description"] ?? '',
                $jsonHoliday["type"]
            );
        }

    }

    

?>