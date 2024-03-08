<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Weather
 *
 * @author webre
 */
class Weather implements Weather_Interface {

    //put your code here
    private $url;

    public function __construct() {
       $this->url = __WEATHER_URL;
    }

    public function get_cities() {
        $cities = file_get_contents(__CITIES_FILE);
        return json_decode($cities,true);
    }

    public function get_weather($cityId) {
        // $url = str_replace("{{$cityId}}", $cityId, $this->url);
        $urllink ="http://api.openweathermap.org/data/2.5/weather?id=$cityId&lang=en&units=metric&APPID=fb0154756f871d5e25f5afc57ae7dde0";
        $url = $urllink;
        // $url = str_replace("{{$apikey}}", __API_KEY, $url);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response,true);
    }

    public function get_current_time() {
        return time();
    }

}
