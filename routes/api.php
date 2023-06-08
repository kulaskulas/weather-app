<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/weather-forecast', function(Request $request) {
    $app_id = config('services.open_weather_key.key');
    $response = Http::get("https://api.openweathermap.org/data/2.5/forecast?lat=$request->latitude&lon=$request->longitude&appid=$app_id&units=metric");
    // $response = Http::get("https://api.openweathermap.org/data/2.5/forecast?q=London,us&appid=$app_id");
   
    return $response->json();
});

Route::get('/current-weather', function(Request $request) {
    $app_id = config('services.open_weather_key.key');
    $response = Http::get("https://api.openweathermap.org/data/2.5/weather?lat=$request->latitude&lon=$request->longitude&appid=$app_id&units=metric");
    return $response->json();
});
