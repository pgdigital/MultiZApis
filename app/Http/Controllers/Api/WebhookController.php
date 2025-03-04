<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\WebhookRequest;
use App\Services\Internal\Whatsapp\WhatsappManagerService;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\BodyParam;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Group;

#[Group("Webhook", "Todos endpoints de webhook")]
class WebhookController extends Controller
{
    public function __construct(protected WhatsappManagerService $whatsappManagerService){}

    #[Endpoint("Setar webhook", <<<DESC
        Atribuir webhook pro número.
    DESC)]
    #[BodyParam("url", "string", required: true, example: "https://example.com/webhook")]
    #[Authenticated]
    public function store(WebhookRequest $request)
    {
        $request->validated();

        try {
            $this->whatsappManagerService->setWebhook($request->instance->name, $request->all());

            return response()->json([
                "message" => "Webhook configurado com sucesso"
            ], 200);
        } catch(\Exception $exception) {
            return response()->json([
                "message" => "Erro ao configurar webhook"
            ], 500);
        }
    }
}
