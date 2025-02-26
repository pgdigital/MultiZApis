<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Services\Internal\Whatsapp\WhatsappManagerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DashboadController extends Controller
{
    public function __construct(protected WhatsappManagerService $whatsappService){}
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $clients = Client::query()->when(auth()->user()->client, function($query) {
            $query->where('id', auth()->user()->client->id);
        })->with('instances')->get();

        $totalChats = Cache::remember('totalChats', now()->addMinutes(20), function() use ($clients) {
            $chats = collect([]);

            foreach ($clients as $client) {
                foreach ($client->instances as $instance) {
                    $chats->push(...$this->whatsappService->getChats($instance->name));
                }
            }

            return $chats->count();
        });

        $totalMessages = Cache::remember('totalMessages', now()->addMinutes(20), function() use ($clients) {
            $messages = collect([]);

            foreach ($clients as $client) {
                foreach ($client->instances as $instance) {
                    $messages->push(...$this->whatsappService->getMessages($instance->name));
                }
            }
            return $messages->sum(fn($message) => $message['total']);
        });

        return view('dashboard',  [
            'totalChats' => $totalChats,
            'totalMessages' => $totalMessages
        ]);
    }
}
