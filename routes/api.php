<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ConnectionController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\InstanceController;
use App\Http\Middleware\AuthenticationTokenInstanceMiddleware;

Route::post('connection/update/{instanceId}', ConnectionController::class);
Route::get('instances/connect/{instance}', [InstanceController::class,'connect'])->name('instances.connect');

Route::group(['prefix' => 'v1', 'as' => 'v1.', 'middleware' => AuthenticationTokenInstanceMiddleware::class], function() {
    Route::post('send/message', [MessageController::class, 'sendMessage'])->name('send-message');
});