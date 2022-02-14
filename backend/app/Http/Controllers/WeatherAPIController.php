<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;


class WeatherAPIController extends Controller
{
    public function index() {
        $weather_info = '';
        $place_name = '';

        return view('weather.index', compact('weather_info', 'place_name'));
    }

    public function search(Request $request) {
        $weather_info = '';
        $place_name = '';
        $zip1 = $request->zip1;
        $zip2 = $request->zip2;

        $result = $this->getWeather($zip1, $zip2);
        $place_name = $this->getPlaceName($zip1, $zip2);
        if ($result == 'error') {
            return redirect(route('weather.index'))->with('error_message', "該当する郵便番号が見つかりませんでした。\n再度検索を行ってください。");
        }
        $result_json  = $result->content();
        $weather_info = json_decode($result_json, true);

        return view('weather.index', compact('weather_info', 'place_name'));
    }

    public function getWeather($zip1, $zip2) {
        $API_KEY = config('services.openweathermap.key');
        $base_url = config('services.openweathermap.url');
        $url = "$base_url?units=metric&APPID=$API_KEY&lang=ja&zip=$zip1-$zip2,jp";

        // 接続
        $client = new Client();
        try {
            $response = $client->request('GET', $url);
    
            $result = json_decode($response->getBody()->getContents(), true);
    
            return response()->json($result);
        } catch ( \Exception $e ) {
            return 'error';
        }
    }

    public function getPlaceName($zip1, $zip2) {
        $url = "https://zipcloud.ibsnet.co.jp/api/search";

        $client = new Client();
        $option = [
            'headers' => [
                'Accept' => '*/*',
                'Content-Type' => 'application/x-www-form-urlencoded' 
            ],
            'form_params' => [
                'zipcode' => $zip1.$zip2
            ]
        ];
        $response = $client->request('POST', $url, $option);
        $result = json_decode($response->getBody()->getContents(), true);

        // statusコードが200かつ住所が設定されている場合のみ返す
        if ($result['status'] == 200 && isset($result['results'][0]['address2'])) {
            return response()->json($result['results'][0]['address2'].$result['results'][0]['address3']);
        } else {
            return 'error';
        }
    }
}