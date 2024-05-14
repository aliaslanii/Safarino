<?php

use App\Http\Controllers\Api\Admin\Airport\AirportController;
use App\Http\Controllers\Api\Admin\City\CityController;
use App\Http\Controllers\Api\Admin\Companies\AirlineController;
use App\Http\Controllers\Api\Admin\Companies\RailcompanieController;
use App\Http\Controllers\Api\Home\Passenger\PassengerController;
use App\Http\Controllers\Api\Admin\Setting\SettingController;
use App\Http\Controllers\Api\Admin\Tickets\AirplaneTicketController;
use App\Http\Controllers\Api\Admin\Tickets\TrainTicketController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Home\Order\OrderController;
use App\Http\Controllers\Api\Home\Tickets\TicketContrroller;
use App\Http\Controllers\Api\Home\User\UserController;
use App\Http\Controllers\Api\Home\Wallet\WalletController;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes Home
|--------------------------------------------------------------------------
*/
Route::prefix('auth')->group(function(){
    Route::post('register', [AuthController::class, 'userRegister']);
    Route::post('login', [AuthController::class, 'userLogin']);
    Route::get('detail', [AuthController::class, 'detail'])->middleware('auth:sanctum');
    Route::get('logout', [AuthController::class, 'userLogout'])->middleware('auth:sanctum');
    Route::delete('destroy', [AuthController::class,'destroy'])->middleware(['role:sanctum','role:admin','role:Read']);
    Route::put('restore', [AuthController::class,'restore'])->middleware(['role:sanctum','role:admin','role:Create']);
});
Route::prefix('User')->group(function(){
    Route::put('ChangePassword', [UserController::class,'changePassword'])->middleware('auth:sanctum');
    Route::put('PersonalInformation', [UserController::class,'personalInformation'])->middleware('auth:sanctum');
    Route::put('BankInformation', [UserController::class,'bankInformation'])->middleware('auth:sanctum');
    Route::put('ChangeMobile', [UserController::class,'changeMobile'])->middleware('auth:sanctum');
    Route::put('ChangeEmail', [UserController::class,'changeEmail'])->middleware('auth:sanctum');
    Route::delete('destroy', [UserController::class,'destroy']);
    Route::put('restore', [UserController::class,'restore']);
});
Route::prefix('Passenger')->middleware(['auth:sanctum'])->group(function(){
    Route::get('create', [PassengerController::class,'create'])->middleware('role:Create');
    Route::post('store', [PassengerController::class,'store'])->middleware('role:Create');
    Route::get('show', [PassengerController::class,'show'])->middleware('role:Read');
    Route::get('edit', [PassengerController::class,'edit'])->middleware('role:Update');
    Route::put('update', [PassengerController::class,'update'])->middleware('role:Update');
    Route::post('Add', [PassengerController::class,'addPassenger']);
});
Route::prefix('wallet')->middleware(['auth:sanctum'])->group(function(){
    Route::post('chargewallet', [WalletController::class,'chargewallet']);
});
Route::prefix('orders')->group(function(){
    Route::get('', [OrderController::class,'orders'])->name('orders');
    // این تست برای قسمت درگاه پرداخت بود  
    Route::get('ticket', [OrderController::class,'ticketCreate'])->name('ticketCreate');
    Route::get('Payment', [OrderController::class,'payMent'])->name('payMent');
    Route::post('Paydone', [OrderController::class,'payDone'])->name('payDone');
    
});
Route::prefix('ticket')->group(function(){
    Route::post('airplane', [TicketContrroller::class,'airplaneTicket']);
    Route::post('trin', [TicketContrroller::class,'trinTicket']);
});
Route::prefix('AirplaneTicket')->group(function(){
    Route::post('search', [AirplaneTicketController::class,'search']);
});
Route::prefix('TrainTicket')->group(function(){
    Route::post('search', [TrainTicketController::class,'search']);
});
/*
|--------------------------------------------------------------------------
| API Routes Admin
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware(['auth:sanctum','role:Admin'])->group(function(){
    Route::prefix('City')->group(function(){
        Route::get('index', [CityController::class,'index'])->middleware('role:Read');
        Route::get('create', [CityController::class,'create'])->middleware('role:Create');
        Route::post('store', [CityController::class,'store'])->middleware('role:Create');
        Route::get('show', [CityController::class,'show'])->middleware('role:Read');
        Route::get('edit', [CityController::class,'edit'])->middleware('role:Update');
        Route::put('update', [CityController::class,'update'])->middleware('role:Update');
        Route::delete('destroy', [CityController::class,'destroy'])->middleware('role:Read');
        Route::put('restore', [CityController::class,'restore'])->middleware('role:Create');
    });
    Route::prefix('AirplaneTicket')->group(function(){
        Route::get('index', [AirplaneTicketController::class,'index'])->middleware('role:Read');
        Route::get('create', [AirplaneTicketController::class,'create'])->middleware('role:Create');
        Route::post('store', [AirplaneTicketController::class,'store'])->middleware('role:Create');
        Route::get('show', [AirplaneTicketController::class,'show'])->middleware('role:Read');
        Route::get('edit', [AirplaneTicketController::class,'edit'])->middleware('role:Update');
        Route::put('update', [AirplaneTicketController::class,'update'])->middleware('role:Update');
        Route::delete('destroy', [AirplaneTicketController::class,'destroy'])->middleware('role:Read');
        Route::put('restore', [AirplaneTicketController::class,'restore'])->middleware('role:Create');
    });
    Route::prefix('TrainTicket')->group(function(){
        Route::get('index', [TrainTicketController::class,'index'])->middleware('role:Read');
        Route::get('create', [TrainTicketController::class,'create'])->middleware('role:Create');
        Route::post('store', [TrainTicketController::class,'store'])->middleware('role:Create');
        Route::get('show', [TrainTicketController::class,'show'])->middleware('role:Read');
        Route::get('edit', [TrainTicketController::class,'edit'])->middleware('role:Update');
        Route::put('update', [TrainTicketController::class,'update'])->middleware('role:Update');
        Route::delete('destroy', [TrainTicketController::class,'destroy'])->middleware('role:Read');
        Route::put('restore', [TrainTicketController::class,'restore'])->middleware('role:Create');
    });
    Route::prefix('Railcompanies')->group(function(){
        Route::get('index', [RailcompanieController::class,'index'])->middleware('role:Read');
        Route::get('create', [RailcompanieController::class,'create'])->middleware('role:Create');
        Route::post('store', [RailcompanieController::class,'store'])->middleware('role:Create');
        Route::get('show', [RailcompanieController::class,'show'])->middleware('role:Read');
        Route::get('edit', [RailcompanieController::class,'edit'])->middleware('role:Update');
        Route::post('update', [RailcompanieController::class,'update'])->middleware('role:Update');
        Route::delete('destroy', [RailcompanieController::class,'destroy'])->middleware('role:Read');
        Route::put('restore', [RailcompanieController::class,'restore'])->middleware('role:Create');
    });
    Route::prefix('Airline')->group(function(){
        Route::get('index', [AirlineController::class,'index'])->middleware('role:Read');
        Route::get('create', [AirlineController::class,'create'])->middleware('role:Create');
        Route::post('store', [AirlineController::class,'store'])->middleware('role:Create');
        Route::get('show', [AirlineController::class,'show'])->middleware('role:Read');
        Route::get('edit', [AirlineController::class,'edit'])->middleware('role:Update');
        Route::post('update', [AirlineController::class,'update'])->middleware('role:Update');
        Route::delete('destroy', [AirlineController::class,'destroy'])->middleware('role:Read');
        Route::put('restore', [AirlineController::class,'restore'])->middleware('role:Create');
    });
    Route::prefix('Airport')->group(function(){
        Route::get('index', [AirportController::class,'index'])->middleware('role:Read');
        Route::get('create', [AirportController::class,'create'])->middleware('role:Create');
        Route::post('store', [AirportController::class,'store'])->middleware('role:Create');
        Route::get('show', [AirportController::class,'show'])->middleware('role:Read');
        Route::get('edit', [AirportController::class,'edit'])->middleware('role:Update');
        Route::put('update', [AirportController::class,'update'])->middleware('role:Update');
        Route::delete('destroy', [AirportController::class,'destroy'])->middleware('role:Read');
        Route::put('restore', [AirportController::class,'restore'])->middleware('role:Create');
    });
    Route::prefix('Setting')->group(function(){
        Route::get('index', [SettingController::class,'index'])->middleware('role:Read');
        Route::post('update', [SettingController::class,'update'])->middleware('role:Update');
    });
});