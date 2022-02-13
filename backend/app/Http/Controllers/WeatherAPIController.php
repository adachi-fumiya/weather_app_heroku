<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class WeatherAPIController extends Controller
{
    public function index() {
        $result = $this->weatherData();
        $result_json  = $result->content();
        $result_array = json_decode( $result_json, true );
        // dd($result_array);
        // echo $result_array;
        return view('weather.index', compact('result_array'));
    }

    public function weatherData() {
        $API_KEY = config('services.openweathermap.key');
        $base_url = config('services.openweathermap.url');
        $city = 'Oita';

        $url = "$base_url?units=metric&q=$city&APPID=$API_KEY&lang=ja";

        // 接続
        $client = new Client();

        $method = "GET";
        $response = $client->request($method, $url);

        $weather_data = $response->getBody();
        $weather_data = json_decode($weather_data, true);

        return response()->json($weather_data);
    }
}
// @foreach($result_array['list'] as $r)
// {{$r['dt_txt']}}
// @endforeach