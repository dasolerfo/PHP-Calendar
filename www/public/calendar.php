<?php

require_once __DIR__ . '/../vendor/autoload.php';

use API\CalendarClient;
use API\CalendarParser;



   // $jsonCalendari = CalendarClient::getCalendarMonth(2);
    //$matriuCalendari = CalendarParser::DateParser($jsonCalendari, 2, 2025);


?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendari Elegant</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right,rgb(235, 154, 255),rgb(244, 196, 250));
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
            width: 350px;
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
            color:rgb(241, 117, 255);
        }
        .days {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
            margin-top: 10px;
        }
        .day, .weekday {
            padding: 10px;
            background:rgb(250, 179, 255);
            border-radius: 6px;
            font-weight: 600;
            color: white;
            text-align: center;
        }
        .weekday {
            background: rgb(241, 117, 255); /* Diferent color per als dies de la setmana */
        }
        .day:hover {
            background:rgb(255, 117, 253);
            color: white;
            cursor: pointer;
        }
        .info-panel {
            width: 250px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            padding: 20px;
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
            color:rgb(250, 117, 255);
        }
        select:focus {
            outline: none;
            border-color:rgb(230, 71, 255);
        }
        h3 {
            color:rgb(218, 71, 255);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="calendar">
            <div class="calendar-header">
                <span>&lt;</span>
                <span>Març 2025</span>
                <span>&gt;</span>
            </div>
            <div class="days">
                <div class="weekday">Dilluns</div>
                <div class="weekday">Dimarts</div>
                <div class="weekday">Dimecres</div>
                <div class="weekday">Dijous</div>
                <div class="weekday">Divendres</div>
                <div class="weekday">Dissabte</div>
                <div class="weekday">Diumenge</div>
                <div class="day">1</div>
                <div class="day">2</div>
                <div class="day">3</div>
                <div class="day">4</div>
                <div class="day">5</div>
                <div class="day">6</div>
                <div class="day">7</div>
                <div class="day">8</div>
                <div class="day">9</div>
                <div class="day">10</div>
                <div class="day">11</div>
                <div class="day">12</div>
                <div class="day">13</div>
                <div class="day">14</div>
                <div class="day">15</div>
                <div class="day">16</div>
                <div class="day">17</div>
                <div class="day">18</div>
                <div class="day">19</div>
                <div class="day">20</div>
                <div class="day">21</div>
                <div class="day">22</div>
                <div class="day">23</div>
                <div class="day">24</div>
                <div class="day">25</div>
                <div class="day">26</div>
                <div class="day">27</div>
                <div class="day">28</div>
                <div class="day">29</div>
                <div class="day">30</div>
                <div class="day">31</div>
            </div>
        </div>
        <div class="info-panel">
            <label for="country"><h3>Selecciona un país:</h3></label>
            <select id="country">
                <option value="espanya">Espanya</option>
                <option value="franca">França</option>
                <option value="italia">Itàlia</option>
                <option value="alemanya">Alemanya</option>
            </select>
            <h3>Festes Nacionals</h3>
            <p id="holidays">Selecciona un país per veure les seves festes.</p>
        </div>
    </div>
</body>
</html>
