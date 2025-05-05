<?php

use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;


Route::group([ 'middleware' => 'api',], function ($router) {

Route::post('register', [AuthController::class,"register"]);
    Route::post('confirmOtp', [AuthController::class,"confirmOtp"]);
    Route::post('resendOtp',[ AuthController::class,"resendOtp"]);
    Route::post('forgetPassword', [AuthController::class,"forgetPassword"]);
    Route::post('resetPassword', [AuthController::class,"resetPassword"]);
    Route::post('login', [AuthController::class,"login"]);

});

Route::group(['middleware'=>'auth:api'],function () {
    Route::post('refresh', [App\Http\Controllers\api\AuthController::class,"refresh"]);
    Route::post('logout', [App\Http\Controllers\api\AuthController::class,"logout"]);

    Route::apiResource('customers', CustomerController::class);

    Route::apiResource('invoices', InvoiceController::class);
    Route::get('invoices/{id}');
    Route::post('invoices/bulk', ['uses'=>'InvoiceController@bulkStore']);
});
//http://127.0.0.1:8025/