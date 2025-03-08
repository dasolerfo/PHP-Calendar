<?php

namespace API;

use GuzzleHttp\Client;


class CalendarClient {

    public int $month;
    const REQUEST_URL = "https://calendarific.com/api/v2/holidays?&api_key=EEBe4wCt7kQ4IknEhxrWEbEJpDBFXz4c&country=ES&year=2025";


    static function getCalendarMonth($month)  {
        $client = new Client();
        $response = $client->request('GET', CalendarClient::REQUEST_URL . '&month='. $month);
        //$this->month = $month;
        return json_decode($response->getBody(), true);
    }

}

?>