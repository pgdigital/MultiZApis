<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Internal\Whatsapp\WhatsappManagerService;
use Illuminate\Http\Request;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\BodyParam;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Group;

#[Group("Mensagens", "Todos endpoints de mensagens")]
class MessageController extends Controller
{
    public function __construct(protected WhatsappManagerService $whatsappService){}
    
    #[Endpoint("Enviar mensagem", <<<DESC
        Endpoint para enviar mensagem pelo Whatsapp.
    DESC)]
    #[BodyParam("phone", "string", required: true, example: "55000000000")]
    #[BodyParam("message", "string", required: true, example: "Hello world!")]
    #[Authenticated]
    public function sendMessage(Request $request)
    {
        $response = $this->whatsappService->sendMessage($request->instance->name, $request->phone, $request->message);
        
        return $response;
    }
}
