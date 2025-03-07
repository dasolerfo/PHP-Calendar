<?php

namespace DB;

use PDO;
use PDOException;

class Database {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        try {
            $this->pdo = new PDO(
                'mysql:host=mysql'.
                ';port=:3306'. 
                ';dbname=AC1_project_db' .
                ';charset=utf8', 
                'pw2user', 
                'pw2pass'
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Error de connexió: " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->pdo;
    }
}





/*$userRepo = new MySQLUserRepository();

$user = new User(null, "dani@example.com", "password123");
$userRepo->save($user);

$foundUser = $userRepo->find($user->id);
if ($foundUser) {
    echo "Usuari trobat: " . $foundUser->name . " (" . $foundUser->email . ")";
} else {
    echo "Usuari no trobat.";
}
*/


?>