<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\WhatsappServiceInterface;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function __construct(protected WhatsappServiceInterface $whatsappService){}
    
    public function sendMessage(Request $request)
    {
        $response = $this->whatsappService::sendMessage($request->instance->name, $request->phone, $request->message);
        
        return $response;
    }
}
