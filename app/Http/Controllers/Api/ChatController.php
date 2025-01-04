<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\WhatsappServiceInterface;

class ChatController extends Controller
{
    public function __construct(protected WhatsappServiceInterface $whatsappService ){}

    public function checkNumberWhatsapp($phone)
    {
        $response = $this->whatsappService->checkWhatsappNumber($phone);

        return $response;
    }
}
