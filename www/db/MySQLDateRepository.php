<?php 
    namespace DB;

    use PDO;
    
    class MySQLDateRepository implements DateRepository {
        private $pdo;

        public function __construct() {
            $this->pdo = Database::getInstance()->getConnection();
        }
    
        public function saveMonth(int $month){

        }
        public function findMonth(int $month): ?string{
            return null;
        }
    }

    

?>