<?

namespace DB;

use PDO;
use Model\User;

class MySQLUserRepository implements UserRepository {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance()->getConnection();
    }

    public function save(User $user) {
        $stmt = $this->pdo->prepare("INSERT INTO Users (email, password, created_at, updated_at) VALUES (?, ?, NOW(), NOW())");
        $stmt->execute([$user->email, $user->password ]);//password_hash($user->password, '2y')
        $user->id = $this->pdo->lastInsertId();
    }

    public function find($id): ?User {
        $stmt = $this->pdo->prepare("SELECT * FROM Users WHERE email = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }
        return new User($row['user_id'], $row['email'], $row['password'], $row['created_at'], $row['updated_at']);
    }

    public function validate($mail, $pass): bool {
        $stmt = $this->pdo->prepare("SELECT * FROM Users WHERE email = ? AND password = ?");
        echo $mail . $pass;
        $stmt->execute([$mail, $pass]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return true;
        }
        return false;
    }
}

?>