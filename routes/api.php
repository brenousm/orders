<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JWTAuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\StatusController;
use App\Http\Middleware\JwtMiddleware;

Route::post('register', [JWTAuthController::class, 'register']);
Route::post('login', [JWTAuthController::class, 'login']);

Route::middleware([JwtMiddleware::class])->group(function () {

    //USER ROUTES
    Route::get('user', [JWTAuthController::class, 'getUser']);
    Route::post('logout', [JWTAuthController::class, 'logout']);

    //STATUS
    Route::get('status',[StatusController::class,'index']);

    //ORDER ROUTE
    Route::get('order',[OrderController::class, 'index']);
    Route::post('order',[OrderController::class, 'store']);
    Route::post('order/cancel',[OrderController::class, 'cancelOrder']);
    Route::post('order/updatestatus',[OrderController::class, 'updateStatus']);
    Route::post('order/notifyrequester',[OrderController::class, 'notifyRequester']);
    Route::get('order/{id}',[OrderController::class, 'show']);

});
