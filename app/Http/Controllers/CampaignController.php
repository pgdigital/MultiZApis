<?php

namespace App\Http\Controllers;

use App\Http\Requests\CampaignRequest;
use App\Models\Campaign;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $campaigns = Campaign::query()
            ->when(auth()->user()->client, function($query, $client) {
                $query->where('client_id', $client->id);
            })
            ->paginate(10);
        
        return view('campaign.index', [
            'campaigns' => $campaigns
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Client::query()->where('status', 'Ativo')->get();

        return view('campaign.create', [
            'clients' => $clients
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CampaignRequest $request)
    {
        $validatedData = $request->validated();

        try {
            Campaign::query()->create($validatedData);

            return back()->with('success', 'Campanha criada com sucesso');
        } catch (\Exception $exception) {
            Log::channel('daily')->error('Erro ao criar a campanha: ' . $exception->getMessage());
            return back()->with('error', 'Não foi possível criar a campanha');
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
    public function destroy(string $id)
    {
        //
    }
}
