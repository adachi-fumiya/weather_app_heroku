<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;


class WeatherAPIController extends Controller
{
    public function index(Request $request) {
        $weather_info = '';
        $place_name = '';

        $post_code1 = $request->post_code1;
        $post_code2 = $request->post_code2;
        if ($post_code1 && $post_code2) {
            $result = $this->getWeather($post_code1, $post_code2);
            $place_name = $this->getPlaceName($post_code1, $post_code2);
            
            // dd($place_name->original);
            if ($result == 'error') {
                return redirect('/weather')->with('error_message', '郵便番号を正しく入力して下さい。');
            }
            $result_json  = $result->content();
            $weather_info = json_decode($result_json, true);
        }

        return view('weather.index', compact('weather_info', 'place_name'));
    }

    public function getWeather($post_code1, $post_code2) {
        $API_KEY = config('services.openweathermap.key');
        $base_url = config('services.openweathermap.url');
        $url = "$base_url?units=metric&APPID=$API_KEY&lang=ja&zip=$post_code1-$post_code2,jp";

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

    public function getPlaceName($post_code1, $post_code2) {
        $url = "https://zipcloud.ibsnet.co.jp/api/search";

        $client = new Client();
        $option = [
            'headers' => [
                'Accept' => '*/*',
                'Content-Type' => 'application/x-www-form-urlencoded' 
            ],
            'form_params' => [
                'zipcode' => $post_code1.$post_code2
            ]
        ];
        $response = $client->request('POST', $url, $option);
        $result = json_decode($response->getBody()->getContents(), true);

        if ($result['status'] == 200) {
            return response()->json($result['results'][0]['address2'].$result['results'][0]['address3']);
        } else {
            return 'error';
        }
    }
}