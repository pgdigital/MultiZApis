<?php

use Illuminate\Support\Facades\Route;
use Modules\EvolutionApi\App\Http\Controllers\EvolutionApiController;

Route::resource('evolutionapi', EvolutionApiController::class)
    ->parameter('evolutionapi', 'configuration');