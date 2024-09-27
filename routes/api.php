<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MainController;
use App\Http\Controllers\Api\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix' => 'v1', 'namespace' => 'Api'], function () {
    Route::get('governorates', [MainController::class, 'governorates']);
    Route::get('cities', [MainController::class, 'cities']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    // Route::post('donation-request/create', [MainController::class, 'donation_request_create']);
    // Route::get('donation-request', [MainController::class, 'donation_request']);
    Route::post('reset-password', [AuthController::class, 'resetPassword']);
    Route::post('password', [AuthController::class, 'password']);

    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('posts', [MainController::class,'posts']);
        Route::get('settings', [MainController::class,'settings']);
        Route::post('register_token',[AuthController::class,'registerToken' ]);
        Route::post('profile',[AuthController::class,'profile' ]);
        Route::post('remove-token',[AuthController::class ,'removeToken']);
        Route::post('donation-request-create',[MainController::class,'donation_request_create']);
        Route::get('notifications-count',[MainController::class,'notificationsCount']);
        Route::post('notifications-setting',[MainController::class,'notificationSettings']);
        Route::get('notifications-list',[AuthController::class,'notificationList']);
        Route::post('post-toggle-favourite',[MainController::class,'postFavourite']);
        Route::get('donationRequest',[MainController::class,'donationRequest']);
        Route::get('donationRequests',[MainController::class,'donationRequests']);
        Route::post('register-token',[AuthController::class,'registerToken']);
        Route::post('contact', [MainController::class, 'contact']);
        // Route::post('profile',[AuthController::class,'profile']);
    });
});


