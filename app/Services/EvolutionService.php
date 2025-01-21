<?php

namespace App\Services;

use App\Interfaces\WhatsappServiceInterface;
use GuzzleHttp\Client;
use App\Models\WhatsappIntegration;

class EvolutionService implements WhatsappServiceInterface
{

    protected Client $clientInstance;
    
    public function __construct()
    {
        $whatsappIntegration = WhatsappIntegration::where("is_active", true)->first();
        
        if (!$whatsappIntegration) {
            throw new \Exception("No active whatsapp integration found");
        }

        $this->clientInstance = new Client([
            "base_uri" => $whatsappIntegration->base_url,
            "headers" => [
                "Content-Type" => "application/json",
                "Accept" => "application/json",
                "apikey" => $whatsappIntegration->token
            ]
        ]);
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
}