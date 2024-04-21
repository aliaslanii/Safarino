<?php

use App\Http\Controllers\CityController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::prefix('city')->group(function(){
    Route::get('', [CityController::class,'index']);
    Route::get('create', [CityController::class,'create']);
    Route::post('store', [CityController::class,'store']);
    Route::post('show', [CityController::class,'show']);
    Route::post('edit', [CityController::class,'edit']);
});