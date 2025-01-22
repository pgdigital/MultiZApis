<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\InstanceController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\DashboadController;

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', DashboadController::class)->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('clientes', ClientController::class)
        ->parameters([
            'clientes' => 'client'
        ])
        ->names([
            'index' => 'clients.index',
            'create' => 'clients.create',
            'store' => 'clients.store',
            'show' => 'clients.show',
            'edit' => 'clients.edit',
            'update' => 'clients.update',
            'destroy' => 'clients.destroy'
        ]);
    Route::post('clientes/reset-password/{client}', [ClientController::class, 'resetPassword'])->name('clients.reset-password');

    Route::resource('instancias', InstanceController::class)
        ->parameters([
            'instancias' => 'instance'
        ])
        ->names([
            'index' => 'instances.index',
            'create' => 'instances.create',
            'store' => 'instances.store',
            'show' => 'instances.show',
            'edit' => 'instances.edit',
            'update' => 'instances.update',
            'destroy' => 'instances.destroy'
        ]);

    Route::post('instancias/recreate/{instance}', [InstanceController::class, 'recreate'])->name('instances.recreate');
    
    Route::get('configuracao/evolution', [ConfigurationController::class, 'index'])->name('configuration.evolution');
    Route::put('configuracao/evolution/{whatsappIntegration}', [ConfigurationController::class, 'update'])->name('configuration.evolution.update');
});

require __DIR__.'/auth.php';
