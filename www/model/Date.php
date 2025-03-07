<?php

namespace Model;

use Model\Holiday;

class Date {
    public int $number;
    public bool $active;
    public array $holidays;

    public function __construct(int $number) {
        $this->number = $number;
        $this->active = false;
        $this->holidays = [];
    }
}

?>