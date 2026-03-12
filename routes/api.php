<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

use App\Http\Controllers\NoteController;
use App\Http\Controllers\ProductController;

use App\Http\Controllers\MovieController;
use App\Http\Controllers\WeatherController;


Route::prefix('auth')->group(function(){

    Route::post('/register',[AuthController::class,'register']);
    Route::post('/login',[AuthController::class,'login']);

});

Route::get('/movies',[MovieController::class,'index']);
Route::get('/movies/{title}',[MovieController::class,'show']);


Route::middleware('auth:api')->group(function(){
    //
	Route::apiResource('products', ProductController::class);
    
	Route::apiResource('notes', NoteController::class);
	
	Route::get('weather', [WeatherController::class, 'show']);
});
	