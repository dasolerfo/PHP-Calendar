<?php

namespace Model;

use Model\Holiday;

class Date {
    public int $number;
    public bool $active;
    public array $holidays;

    public function __construct(int $number, bool $active = false) {
        $this->number = $number;
        $this->active = $active;
        $this->holidays = [];
    }
}

?>