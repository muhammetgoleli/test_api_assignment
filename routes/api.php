<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\ChatController;


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth', [AuthController::class, 'authenticate']);
    Route::post('/subscription', [SubscriptionController::class, 'store']);
    Route::post('/chat', [ChatController::class, 'chat']);
});


Route::group(['middleware' => 'admin'], function () {
    Route::post('/admin/subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions.index');
});


