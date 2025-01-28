<?php

namespace App\Observers;

use App\Interfaces\WhatsappServiceInterface;
use App\Models\Instance;

class InstanceObserver
{
    public function created(Instance $instance)
    {
        $whatsappService = app()->make(WhatsappServiceInterface::class);

        $whatsappService::createInstance([
            "instanceName" => $instance->name,
            "token" => $instance->token,
            "integration" => "WHATSAPP-BAILEYS"
        ]);

        $whatsappService::setWebsocketInstance($instance->name, [
            "enabled" => true,
            "events" => [
                "QRCODE_UPDATED",
                "CONNECTION_UPDATE"
            ]
        ]);
    }
}
