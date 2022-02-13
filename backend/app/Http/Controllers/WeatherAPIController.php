<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;


class WeatherAPIController extends Controller
{
    public function index(Request $request) {
        $weather_info = '';

        if ($request->post_code1 && $request->post_code2) {
            $post_code = $request->post_code1."-".$request->post_code2;
            $result = $this->weatherData($post_code);
            if ($result == 'error') {
                return redirect('/weather')->with('error_message', '郵便番号を正しく入力して下さい。');
            }
            $result_json  = $result->content();
            $weather_info = json_decode($result_json, true);
        }

        return view('weather.index', compact('weather_info'));
    }

    public function weatherData($post_code) {
        $API_KEY = config('services.openweathermap.key');
        $base_url = config('services.openweathermap.url');
        $url = "$base_url?units=metric&APPID=$API_KEY&lang=ja&zip=$post_code,jp";

        // 接続
        $client = new Client();
        try {
            $method = "GET";
            $response = $client->request($method, $url);
    
            $weather_data = $response->getBody();
            $weather_data = json_decode($weather_data, true);
    
            return response()->json($weather_data);
        } catch ( \Exception $e ) {
            return 'error';
        }
    }
}