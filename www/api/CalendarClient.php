<?php

namespace API;

use GuzzleHttp\Client;


class CalendarClient {

    public int $month;
    const REQUEST_URL = "https://calendarific.com/api/v2/holidays?&api_key=baa9dc110aa712sd3a9fa2a3dwb6c01d4c875950dc32vs&country=ESP&year=2025";


    function getCalendarMonth($month)  {
        $client = new Client();
        $response = $client->request('GET', CalendarClient::REQUEST_URL . $month);
       return json_decode($response->getBody());
    }

}

?>