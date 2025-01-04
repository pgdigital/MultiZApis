<?php

namespace App\Observers;

use App\Models\Instance;
use App\Services\EvolutionService;

class InstanceObserver
{
    public function created(Instance $instance)
    {
        EvolutionService::createInstance([
            "instanceName" => $instance->name,
            "token" => $instance->token,
            "integration" => "WHATSAPP-BAILEYS"
        ]);

        EvolutionService::setWebsocketInstance($instance->name, [
            "enabled" => true,
            "events" => [
                "QRCODE_UPDATED",
                "CONNECTION_UPDATE"
            ]
        ]);

        EvolutionService::instanceConnect($instance->name);
    }
}
