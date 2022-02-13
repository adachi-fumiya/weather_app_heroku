<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherAPIController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::controller(WeatherAPIController::class)->group(function () {
    Route::get('/weather', 'index')->name('weather.index');
    Route::get('/weather/weatherData', 'getWeather')->name('weather.getWeather');
    Route::get('/weather/getPlaceName', 'getPlaceName')->name('weather.getPlaceName');
    Route::post('/weather/search', 'search')->name('weather.search');
});