<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class WeatherAPIController extends Controller
{
    public function weatherData() {
        $API_KEY = config('services.openweathermap.key');
        $base_url = config('services.openweathermap.url');
        $city = 'Tokyo';

        $url = "$base_url?units=metric&q=$city&APPID=$API_KEY";

        // 接続
        $client = new Client();

        $method = "GET";
        $response = $client->request($method, $url);

        $weather_data = $response->getBody();
        $weather_data = json_decode($weather_data, true);

        return response()->json($weather_data);
    }
}
