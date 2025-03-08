<?php

require_once __DIR__ . '/../vendor/autoload.php';

use API\CalendarClient;
use API\CalendarParser;
    
    const MESOS_CAT = ["Gener", "Febrer", "Març", "Abril", "Maig", "Juny", "Juliol", "Agost", "Setembre", "Octubre", "Novembre", "Desembre" ];

    if (!isset($_SESSION["logged"]) || $_SESSION["logged"] == false ) {

        session_start();
        header("Location: /login", true);
        exit();


    } else {

        if ($_SERVER["REQUEST_METHOD"] == "GET"){

            $month = $_GET['month'] ?? '';
            $county = $_GET['country'] ?? '';
            $day = $_GET['day'] ?? '';

        } else {

            $month = date('m');
            $year = date('Y');
            $country = 'ES';
        
        }
    }



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
            color:rgb(74, 71, 255);
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
                <div class="weekday">Dll</div>
                <div class="weekday">Dmts</div>
                <div class="weekday">Dmcs</div>
                <div class="weekday">Djs</div>
                <div class="weekday">Dvd</div>
                <div class="weekday">Dss</div>
                <div class="weekday">Dmg</div>
                <div class="day">1</div>
                <div class="day">2</div>
                <div class="day disabled">3</div>
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
                <div class="day disabled">17</div>
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
