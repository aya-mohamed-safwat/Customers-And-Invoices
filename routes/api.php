<?php

use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\InvoiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("login",[App\Http\Controllers\api\AuthController::class,"login"]);
Route::post("register",[App\Http\Controllers\api\AuthController::class,"register"]);
Route::post("logout",[App\Http\Controllers\api\AuthController::class,"logout"])->middleware("auth:sanctum");


Route::group(['middleware'=>'auth:sanctum'],function () {
    Route::apiResource('customers', CustomerController::class);

    Route::apiResource('invoices', InvoiceController::class);
    Route::post('invoices/bulk', ['uses'=>'InvoiceController@bulkStore']);
});