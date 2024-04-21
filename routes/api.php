<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\City\CityControllerapi;
use App\Http\Controllers\Api\Order\OrderController;
use App\Http\Controllers\Api\Passenger\PassengerController;
use App\Http\Controllers\Api\Passenger\PassengerHomeController;
use App\Http\Controllers\Api\Tickets\Admin\AirplaneTicketController;
use App\Http\Controllers\Api\Tickets\Admin\TrainTicketController;
use App\Http\Controllers\Api\Tickets\Home\AirplaneTicketHomeController;
use App\Http\Controllers\Api\Tickets\Home\TicketHomeController;
use App\Http\Controllers\Api\Tickets\Home\TrainTicketHomeController;
use App\Http\Controllers\Api\WalletController;
use App\Http\Controllers\UserControllerapi;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('auth')->group(function(){
    Route::post('register', [AuthController::class, 'userRegister']);
    Route::post('login', [AuthController::class, 'userLogin']);
    Route::get('detail', [AuthController::class, 'detail'])->middleware('auth:sanctum');
    Route::get('logout', [AuthController::class, 'userLogout'])->middleware('auth:sanctum');
});
Route::prefix('User')->group(function(){
    Route::get('show', [UserControllerapi::class,'show'])->middleware('auth:sanctum');
    Route::put('update', [UserControllerapi::class,'update'])->middleware('auth:sanctum');
    Route::delete('destroy', [UserControllerapi::class,'destroy']);
    Route::put('restore', [UserControllerapi::class,'restore']);
});
Route::prefix('Passenger')->middleware(['auth:sanctum'])->group(function(){
    Route::get('create', [PassengerController::class,'create'])->middleware('auth.create');
    Route::post('store', [PassengerController::class,'store'])->middleware('auth.create');
    Route::get('show', [PassengerController::class,'show'])->middleware('auth.read');
    Route::get('edit', [PassengerController::class,'edit'])->middleware('auth.update');
    Route::put('update', [PassengerController::class,'update'])->middleware('auth.update');
    Route::delete('destroy', [PassengerController::class,'destroy'])->middleware('auth.read');
    Route::put('restore', [PassengerController::class,'restore'])->middleware('auth.create');
});
Route::prefix('wallet')->middleware(['auth:sanctum'])->group(function(){
    Route::post('chargewallet', [WalletController::class,'chargewallet']);
});
Route::prefix('order')->group(function(){
    Route::get('ticket', [OrderController::class,'ticketCreate'])->name('ticketCreate');
    Route::post('Payment', [OrderController::class,'payMent'])->name('payMent');
    Route::post('Paydone', [OrderController::class,'payDone'])->name('payDone');
});
Route::prefix('ticket')->group(function(){
    Route::post('airplane', [TicketHomeController::class,'airplaneTicket']);
    Route::post('trin', [TicketHomeController::class,'trinTicket']);
});
Route::prefix('passenger')->middleware(['auth:sanctum'])->group(function(){
    Route::post('Add', [PassengerHomeController::class,'addPassenger']);
});
Route::prefix('admin')->middleware(['auth:sanctum','auth.admin'])->group(function(){
    Route::prefix('City')->group(function(){
        Route::get('index', [CityControllerapi::class,'index'])->middleware('auth.read');
        Route::get('create', [CityControllerapi::class,'create'])->middleware('auth.create');
        Route::post('store', [CityControllerapi::class,'store'])->middleware('auth.create');
        Route::get('show', [CityControllerapi::class,'show'])->middleware('auth.read');
        Route::get('edit', [CityControllerapi::class,'edit'])->middleware('auth.update');
        Route::put('update', [CityControllerapi::class,'update'])->middleware('auth.update');
        Route::delete('destroy', [CityControllerapi::class,'destroy'])->middleware('auth.read');
        Route::put('restore', [CityControllerapi::class,'restore'])->middleware('auth.create');
    });
    Route::prefix('AirplaneTicket')->group(function(){
        Route::get('index', [AirplaneTicketController::class,'index'])->middleware('auth.read');
        Route::get('create', [AirplaneTicketController::class,'create'])->middleware('auth.create');
        Route::post('store', [AirplaneTicketController::class,'store'])->middleware('auth.create');
        Route::get('show', [AirplaneTicketController::class,'show'])->middleware('auth.read');
        Route::get('edit', [AirplaneTicketController::class,'edit'])->middleware('auth.update');
        Route::put('update', [AirplaneTicketController::class,'update'])->middleware('auth.update');
        Route::delete('destroy', [AirplaneTicketController::class,'destroy'])->middleware('auth.read');
        Route::put('restore', [AirplaneTicketController::class,'restore'])->middleware('auth.create');
    });
    Route::prefix('TrainTicket')->group(function(){
        Route::get('index', [TrainTicketController::class,'index'])->middleware('auth.read');
        Route::get('create', [TrainTicketController::class,'create'])->middleware('auth.create');
        Route::post('store', [TrainTicketController::class,'store'])->middleware('auth.create');
        Route::get('show', [TrainTicketController::class,'show'])->middleware('auth.read');
        Route::get('edit', [TrainTicketController::class,'edit'])->middleware('auth.update');
        Route::put('update', [TrainTicketController::class,'update'])->middleware('auth.update');
        Route::delete('destroy', [TrainTicketController::class,'destroy'])->middleware('auth.read');
        Route::put('restore', [TrainTicketController::class,'restore'])->middleware('auth.create');
    });
});
Route::prefix('AirplaneTicket')->group(function(){
    Route::post('search', [AirplaneTicketHomeController::class,'search']);
});
Route::prefix('TrainTicket')->group(function(){
    Route::post('search', [TrainTicketHomeController::class,'search']);
});
