<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Internal\Whatsapp\WhatsappManagerService;

class ChatController extends Controller
{
    public function __construct(protected WhatsappManagerService $whatsappService ){}

    public function checkNumberWhatsapp($phone)
    {
        $response = $this->whatsappService->checkWhatsappNumber($phone);

        return $response;
    }
}
