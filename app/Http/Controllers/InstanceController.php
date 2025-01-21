<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instance;
use App\Models\Client;
use App\Models\WhatsappIntegration;
use App\Http\Requests\InstanceRequest;
use App\Services\EvolutionService;
use Illuminate\Support\Facades\Log;

class InstanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $instances = Instance::query()
            ->with('client.user')
            ->when(auth()->user()->client, function ($query, $client) {
                $query->where('client_id', $client->id);
            })
            ->paginate(10);
        
        $canRegister = Client::query()
            ->where('clients.status', 'Ativo')
            ->leftJoin('instances', 'clients.id', '=', 'instances.client_id')
            ->select('clients.*')
            ->selectRaw('count(instances.id) as instances_count')
            ->groupBy('clients.id')
            ->havingRaw('clients.quantity_instance > count(instances.id)')
            ->exists();

        $whatsappIntegration = WhatsappIntegration::where("is_active", true)->first();
        
        return view('instance.index', [
            'instances' => $instances,
            'wssUrl' => str_replace("https", "wss", $whatsappIntegration->base_url),
            'canRegister' => $canRegister,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clientQuantityInstances = Instance::when(auth()->user()->client, function($query) {
            $query->where('client_id', auth()->user()->client->id);
        })->count();

        if(
            auth()->user()->client && 
            auth()->user()->client->quantity_instance == $clientQuantityInstances)
        {
            abort(403, 'Você não tem mais limite de instâncias');
        }

        $clients = Client::query()->where('clients.status', 'Ativo')
            ->leftJoin('instances', 'clients.id', '=', 'instances.client_id')
            ->select('clients.*')
            ->selectRaw('count(instances.id) as instances_count')
            ->groupBy('clients.id')
            ->havingRaw('clients.quantity_instance > count(instances.id)')
        ->get();

        return view('instance.create', [
            'clients' => $clients,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InstanceRequest $request)
    {
        $validatedData = $request->validated();
        
        try {
            Instance::create($validatedData);
            return redirect()->route('instances.index')->with('success', 'Instância criada com sucesso!');
        } catch (\Exception $e) {
            dd($e);
            return back()->with('error', 'Erro ao criar instância!');
        }
    }

    public function recreate(Instance $instance)
    {
        try{
            $instance->update([
                'status' => 'Aguardando ler QrCode',
            ]);
            
            EvolutionService::deleteInstance($instance->name);
    
            EvolutionService::createInstance([
                "instanceName" => $instance->name,
                "token" => $instance->token,
                "integration" => "WHATSAPP-BAILEYS"
            ]);
    
            EvolutionService::setWebsocketInstance($instance->name, [
                "enabled" => true,
                "events" => [
                    "QRCODE_UPDATED",
                    "CONNECTION_UPDATE"
                ]
            ]);
    
            EvolutionService::instanceConnect($instance->name);
    
            return back()->with('success', 'Instância recriada com sucesso!');
        } catch (\Exception $e) {
            Log::channel('daily')->error("Erro ao recriar instância: ".json_encode($e->getMessage()));
            return back()->with('error', 'Erro ao recriar instância!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Instance $instance)
    {
        try {

            EvolutionService::deleteInstance($instance->name);

            $instance->delete();
            return back()->with('success', 'Instância excluída com sucesso');
        } catch (\Exception $exception) {
            dd($exception);
            Log::channel('daily')->error('Erro ao excluir o instância: ' . $exception->getMessage());
            return back()->with('error', 'Não foi possível excluir o instância');
        }
    }

    public function connect(Instance $instance)
    {
        return EvolutionService::instanceConnect($instance->name);
    }
}
