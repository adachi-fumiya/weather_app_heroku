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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::controller(WeatherAPIController::class)->group(function () {
    Route::get('/', 'index')->name('weather.index');
    Route::get('/weatherData', 'getWeather')->name('weather.getWeather');
    Route::get('/getPlaceName', 'getPlaceName')->name('weather.getPlaceName');
    Route::post('/search', 'search')->name('weather.search');
});