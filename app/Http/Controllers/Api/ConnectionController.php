<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Instance;

class ConnectionController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($instanceName)
    {
        Instance::query()->where('name', $instanceName)->update([
            'status' => 'Conectado'
        ]);
    }
}
