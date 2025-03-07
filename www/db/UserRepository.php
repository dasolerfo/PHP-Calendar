<?
namespace DB;

use Model\User;

interface UserRepository {
    public function save(User $user);
    public function find(int $id): ?User;
    public function validate($mail, $pass): bool ;
}

?>