<?php

namespace Modules\EvolutionApi\App\Services;

use App\Interfaces\WhatsappServiceInterface;
use GuzzleHttp\Client;
use Modules\EvolutionApi\App\Models\Configuration;

class WhatsappProvider implements WhatsappServiceInterface {
    protected Client $clientInstance;
    protected Configuration|null $configuration;
    
    public function __construct()
    {
        $this->configuration = Configuration::query()
            ->whereRaw("
                quantity_instances >
                (
                    SELECT count(instances.id) FROM instances WHERE providerable_type = 'Modules\\EvolutionApi\\App\\Models\\Configuration' and providerable_id = evolution_api_configurations.id
                )
            ")
            ->where("is_active", true)->first();
            
        if (!$this->configuration) {
            return;
        }

        $this->clientInstance = new Client([
            "base_uri" => $this->configuration->api_url,
            "headers" => [
                "Content-Type" => "application/json",
                "Accept" => "application/json",
                "apikey" => $this->configuration->global_token_api
            ]
        ]);
    }

    public function getConfigurationInstance()
    {
        if(!$this->configuration) {
            return null;
        }

        return $this->configuration::class;
    }

    public function getConfigurationId()
    {
        return $this->configuration?->id;
    }

    public static function getAllInstances()
    {
        $response = (new self)->clientInstance->get("/instance/fetchInstances");

        return json_decode($response->getBody()->getContents(), true);
    }

    public static function instanceConnect($instanceName)
    {
        $response = (new self)->clientInstance->get("/instance/connect/{$instanceName}");

        return json_decode($response->getBody()->getContents(), true);
    }

    public static function createInstance(array $data)
    {
        $response = (new self)->clientInstance->post("/instance/create", [
            "body" => json_encode($data)
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public static function restartInstance($instanceName)
    {
        $response = (new self)->clientInstance->post("/instance/restart/{$instanceName}");

        return json_decode($response->getBody()->getContents(), true);
    }

    public static function logoutInstance($instanceName)
    {
        $response = (new self)->clientInstance->post("/instance/logout/{$instanceName}");

        return json_decode($response->getBody()->getContents(), true);
    }

    public static function deleteInstance($instanceName)
    {

        $instanceStatus = self::getConnectionState($instanceName);

        if($instanceStatus['instance']['state'] != 'close') {
            (new self)->clientInstance->delete("/instance/logout/{$instanceName}");
        }
        
        $response = (new self)->clientInstance->delete("/instance/delete/{$instanceName}");

        return json_decode($response->getBody()->getContents(), true);
    }

    public static function setProxyInstance($instanceName, $data)
    {
        $response = (new self)->clientInstance->post("/proxy/set/{$instanceName}", [
            "body" => json_encode($data)
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public static function setWebsocketInstance($instanceName, $data)
    {
        $response = (new self)->clientInstance->post("/websocket/set/{$instanceName}", [
            "body" => json_encode([
                'websocket' => $data
            ])
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public static function setSettingsInstance($instanceName, $data)
    {
        $response = (new self)->clientInstance->post("/settings/set/{$instanceName}", [
            "body" => json_encode($data)
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public static function checkWhatsappNumber($instanceName, $phone)
    {
        $response = (new self)->clientInstance->post("/chat/whatsappNumbers/{$instanceName}", [
            'body' => json_encode([
                'numbers' => [$phone]
            ])
        ]);

        return json_decode($response->getBody()->getContents(), true)[0]['exists'];
    }

    public static function sendMessage($instanceName, $phone, $message)
    {
        $response = (new self)->clientInstance->post("/message/sendText/{$instanceName}", [
            'body' => json_encode([
                'number' => $phone,
                'text' => $message,
                'delay' => 1200
            ])
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public static function getChats($instanceName)
    {
        $response = (new self)->clientInstance->post("/chat/findChats/{$instanceName}");

        return json_decode($response->getBody()->getContents(), true);
    }

    public static function getMessages($instanceName)
    {
        $response = (new self)->clientInstance->post("/chat/findMessages/{$instanceName}");

        return json_decode($response->getBody()->getContents(), true);
    }

    public static function getConnectionState($instanceName)
    {
        $response = (new self)->clientInstance->get("/instance/connectionState/{$instanceName}");

        return json_decode($response->getBody()->getContents(), true);
    }
}