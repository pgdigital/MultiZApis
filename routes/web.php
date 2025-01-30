<?php

use App\Http\Controllers\CampaignController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\InstanceController;
use App\Http\Controllers\ConfigurationController;
use App\Http\Controllers\DashboadController;
use App\Http\Controllers\PlanController;

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

    Route::resource('numeros', InstanceController::class)
        ->parameters([
            'numeros' => 'instance'
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

    Route::post('numeros/recreate/{instance}', [InstanceController::class, 'recreate'])->name('instances.recreate');
    Route::resource('campanhas', CampaignController::class)
        ->parameters([
            'campanhas' => 'campaign'
        ])
        ->names([
            'index' => 'campaigns.index',
            'create' => 'campaigns.create',
            'store' => 'campaigns.store',
            'show' => 'campaigns.show',
            'edit' => 'campaigns.edit',
            'update' => 'campaigns.update',
            'destroy' => 'campaigns.destroy'
        ]);
    
    Route::resource('planos', PlanController::class)
        ->parameters([
            'planos' => 'plan'
        ])->names([
            'index' => 'plans.index',
            'create' => 'plans.create',
            'store' => 'plans.store',
            'show' => 'plans.show',
            'edit' => 'plans.edit',
            'update' => 'plans.update',
            'destroy' => 'plans.destroy'
        ]);  
    Route::get('configuracao', [ConfigurationController::class, 'index'])->name('configuration.index');    
    Route::put('configuracao/{configuration}', [ConfigurationController::class, 'update'])->name('configuration.update');
    Route::get('configuracao/email/resetar-senha', [ConfigurationController::class, 'emailResetPassowrd'])->name('configuration.email.reset-password');
    Route::put('configuracao/email/resetar-senha/{template}', [ConfigurationController::class, 'updateEmailResetPassword'])->name('configuration.email.reset-password.update');
    Route::get('configuracao/evolution', [ConfigurationController::class, 'evolution'])->name('configuration.evolution');
    Route::put('configuracao/evolution/{whatsappIntegration}', [ConfigurationController::class, 'updateEvolution'])->name('configuration.evolution.update');
});

require __DIR__.'/auth.php';
