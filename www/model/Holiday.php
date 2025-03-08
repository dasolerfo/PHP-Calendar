<?php

namespace Model;

class Holiday {
    public $name;
    public $description;
    public $type;
    public $date;

    public function __construct( $date, $name = "", $description = "", $type = "", ) {
        $this->name = $name;
        $this->description = $description;
        $this->type = $type;
        $this->date = $date;
    }
}

?>