<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ConnectionController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Middleware\AuthenticationTokenInstanceMiddleware;

Route::post('connection/update/{instanceName}', ConnectionController::class);

Route::group(['prefix' => 'v1', 'middleware' => AuthenticationTokenInstanceMiddleware::class], function() {
    Route::post('send/message', [MessageController::class, 'sendMessage']);
});