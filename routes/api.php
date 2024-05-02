<?php

use App\Http\Controllers\CarController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Twilio\Rest\Api\V2010\Account\Call\PaymentContext;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::post('update/user', [UserController::class, 'updateUser']);
    Route::get('get/users', [UserController::class, 'getUsers']);
    Route::get('my/profile', [UserController::class, 'myProfile']);
    Route::get('search/user', [UserController::class, 'searchUsers']);

    Route::post('add/car', [CarController::class, 'addCar']);
    Route::post('update/car', [CarController::class, 'updateCar']);
    Route::get('get/cars', [CarController::class, 'getCars']);
    Route::get('search/cars', [CarController::class, 'searchCars']);
    
    Route::post('add/wallet', [PaymentController::class, 'addWallet']);
    Route::get('my/wallet', [PaymentController::class, 'myWallet']);
    Route::post('payment/sale', [PaymentController::class, 'paymentSale']);
    
    Route::get('get/unemployed', [WorkController::class, 'getUnemployed']);
    Route::get('get/job', [WorkController::class, 'getJob']);
    Route::post('send/request', [WorkController::class, 'sendRequest']);
    Route::post('accept/job/{work_id}', [WorkController::class, 'acceptJob']);
    Route::post('start/work/{work_id}', [WorkController::class, 'startWork']);
    Route::post('end/work/{work_id}', [WorkController::class, 'endWork']);
    Route::get('my/works', [WorkController::class, 'myWorks']);
    Route::get('my/orders', [WorkController::class, 'myOrders']);

});
