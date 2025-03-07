<?php

require_once __DIR__ . '/../vendor/autoload.php';

use API\CalendarClient;
use API\CalendarParser;



    $jsonCalendari = CalendarClient::getCalendarMonth(1);
    $matriuCalendari = CalendarParser::DateParser($jsonCalendari, 1, 2025);


?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendar</title>
    <style>
    </style>
</head>
<body>

</body>
</html>
