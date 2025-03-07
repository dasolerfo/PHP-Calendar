<?php

namespace Model;

class Holiday {
    public $name;
    public $description;
    public $type;
    public $date;

    public function __construct( $name = "", $description = "", $type = "", $date) {
        $this->name = $name;
        $this->description = $description;
        $this->type = $type;
        $this->date = $date;
    }
}

?>