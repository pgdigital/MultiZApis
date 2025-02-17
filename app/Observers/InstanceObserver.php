<?php

namespace App\Observers;

use App\Models\Instance;
use App\Services\Internal\Whatsapp\WhatsappManagerService;

class InstanceObserver
{
    public function creating(Instance $instance)
    {
        $whatsappService = app()->make(WhatsappManagerService::class);

        $instance->providerable_type = $whatsappService->getConfigurationInstance();
        $instance->providerable_id = $whatsappService->getConfigurationId();
    }

    public function created(Instance $instance)
    {
        $whatsappService = app()->make(WhatsappManagerService::class);

        $whatsappService->createInstance([
            "instanceName" => $instance->name,
            "token" => $instance->token,
            "integration" => "WHATSAPP-BAILEYS"
        ]);

        $whatsappService->setWebsocketInstance($instance->name, [
            "enabled" => true,
            "events" => [
                "QRCODE_UPDATED",
                "CONNECTION_UPDATE"
            ]
        ]);
    }
}
