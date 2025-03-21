<?php

require_once __DIR__ . '/../vendor/autoload.php';

use API\CalendarClient;
use API\CalendarParser;
use DB\MySQLDateRepository;

    const MESOS_CAT = ["Gener", "Febrer", "Març", "Abril", "Maig", "Juny", "Juliol", "Agost", "Setembre", "Octubre", "Novembre", "Desembre" ];
    
   session_start();
   if (!isset($_SESSION["logged"])) {
       header("Location: /login", true);
        exit();

    } else {        
            if ($_SESSION["logged"] == false){
                header("Location: /login", true);
                exit();
            }

            $month = $_GET['month'] ?? date('m');
            $country = $_GET['country'] ?? 'ES';
            $day = $_GET['day'] ?? '';
            $days = [];

            $dateRepo = new MySQLDateRepository();
            $holidays = $dateRepo->findHolidays($month, $country);

            if (!$holidays){

                $holidays = CalendarClient::getCalendarMonth($month, $country);
                $dateRepo->saveHolidays($holidays, $country, $month, MESOS_CAT[$month - 1]);
                $calendar = CalendarParser::DateParserJson($holidays, $month, 2025);

            } else {
                $calendar = CalendarParser::DateParserSQL($holidays, $month, 2025);
            }

            if ($day != ''){
               $days = $dateRepo->findHolidaysDay($month, $country, $day);

            }
   }
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendari</title>
    <script src="./js/calendar.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right,rgb(154, 157, 255),rgb(200, 196, 250));
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            display: flex;
            gap: 20px;
        }
        .calendar {
            width: 550px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            padding: 20px;
            text-align: center;
        }
        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 20px;
            font-weight: 600;
            padding-bottom: 10px;
            border-bottom: 2px solidrgb(237, 117, 255);
            color:rgb(131, 117, 255);
        }
        .days {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
            margin-top: 10px;
        }
        .day, .weekday {
            width: 53.5px;
            padding: 10px;
            background:rgb(179, 185, 255);
            border-radius: 6px;
            font-weight: 600;
            color: white;
            text-align: center;
        }
        .weekday {
            border-radius: 4px;
            background: rgb(84, 78, 255); /* Diferent color per als dies de la setmana */
        }

        .day:hover {
            background:rgb(131, 117, 255);
            color: white;
            cursor: pointer;
        }

        .disabled:hover {
            background: #d3d3d3; /* No canviar el color de fons en hover */
            cursor: not-allowed; /* Mantenir el cursor desactivat */
        }

        .seleccionable{
            cursor:  pointer;
        }

        .holiday:hover {
            background:rgb(88, 250, 88);
            cursor: pointer; /* Mantenir el cursor desactivat */
        }

        .info-panel {
            width: 250px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            padding: 20px;
        }

        .disabled {
            background: #d3d3d3; 
            color: #a9a9a9; 
            cursor: not-allowed;
        }

        .holiday {
            background:rgb(162, 254, 164);
            /*color:rgb(138, 255, 117);*/
            color: white;
        }
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 2px solidrgb(244, 117, 255);
            border-radius: 6px;
            background:rgb(254, 245, 255);
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            font-weight: 600;
            color:rgb(119, 117, 255);
        }
        select:focus {
            outline: none;
            border-color:rgb(86, 71, 255);
        }
        h3 {
            font-size: medium;
            margin-top: 0px;
            margin-bottom: 7px;
            color:rgb(74, 71, 255);
        }

        .holiday-list {
            margin-top: 2px;
            margin-bottom: 0px;
            list-style: none;
            padding: 0;
        }
        .holiday-item {
            background:rgb(119, 117, 255);
            color: white;
            padding: 8px;
            border-radius: 6px;
            margin-top: 5px;
            text-align: center;
            font-size: medium;
            font-weight: 550;
        }

        .holiday-description {
            background:rgb(160, 159, 249);
            color: white;
            padding: 8px;
            border-radius: 6px;
            margin-top: 5px;
            text-align: center;
            font-size: small;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="calendar">
            <div class="calendar-header">
                <span class="seleccionable">&lt;</span>
                <span><?= MESOS_CAT[$month - 1] . " 2025" ?></span>
                <span class="seleccionable">&gt;</span>
            </div>
            <div class="days">
                <div class="weekday">Dll</div>
                <div class="weekday">Dmts</div>
                <div class="weekday">Dmcs</div>
                <div class="weekday">Djs</div>
                <div class="weekday">Dvd</div>
                <div class="weekday">Dss</div>
                <div class="weekday">Dmg</div>

                <?
                $printado = "";
                for ($i = 0; $i < 6; $i++) {
                    for ($j = 0; $j < 7; $j++) {
                        if (isset($calendar[$i][$j])){
                            if($calendar[$i][$j]->active == true){
                                $printado .= "<div class=\"day " . (empty($calendar[$i][$j]->holidays) ? "" : "holiday") . "\">". $calendar[$i][$j]->number . "</div>";
                            } else { 
                                $printado .= "<div class=\"day disabled\">". $calendar[$i][$j]->number . "</div>";
                            }

                        }
                    }
                }
                echo $printado 

                ?>
            </div>
        </div>
        <div class="info-panel">
            <label for="country"><h3>Selecciona un país:</h3></label>
            <select id="country">
                <option value="ES" <?= $country == "ES" ? "selected" : "" ?>>Espanya</option>
                <option value="FR" <?= $country == "FR" ? "selected" : "" ?>>França</option>
                <option value="IT" <?= $country == "IT" ? "selected" : "" ?>>Itàlia</option>
                <option value="DE" <?= $country == "DE" ? "selected" : "" ?>>Alemanya</option>
            </select>
            <h3>Festes Nacionals: 
            <?php
                if ($day!= '' && $month != '') {echo $day . "/" . $month;}
            ?> 

            </h3>

            <?php 
            if (empty($days))
                echo "<p id=\"holidays\">Selecciona un país i dia verd per veure les seves festes.</p>"; ?>
            <ul class="holiday-list">

                <?php 
                foreach ($days as $dia){
                    echo "<li class=\"holiday-item\">". $dia["holiday_name"] . "</li>" ;
                    echo "<li class=\"holiday-description\">". $dia["holiday_description"] . "</li>" ;
                }
                
                ?>
               
            </ul>
        </div>
    </div>
</body>
</html>
