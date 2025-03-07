<?php

namespace Model;

class User {
    public $id;
    public $email;
    public $password;
    public $created_at;
    public $updated_at;

    public function __construct($id = null, $email = "", $password = "", $created_at = null, $updated_at = null) {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }
}

?>