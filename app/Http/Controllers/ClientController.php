<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\User;
use App\Http\Requests\ClientRequest;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::query()->paginate(10);

        return view('client.index', [
            'clients' => $clients
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('client.create');
    }

    /**Request
     * Store a newly created resource in storage.
     */
    public function store(ClientRequest $request)
    {
        $validatedData = $request->validated();

        DB::beginTransaction();
        try {
            $user = User::query()->create($validatedData);

            $user->client()->create($validatedData);
            
            DB::commit();
            return back()->with('success', 'Cliente criado com sucesso');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::channel('daily')->error('Erro ao criar o cliente: ' . $exception->getMessage());
            return back()->with('error', 'Não foi possível criar o cliente');
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
    public function edit(Client $client)
    {
        return view('client.edit', [
            'client' => $client
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClientRequest $request, Client $client)
    {
        $valdiatedData = $request->validated();

        DB::beginTransaction();
        try {
            $client->update($valdiatedData);

            $client->user->update($valdiatedData);

            DB::commit();
            return back()->with('success', 'Cliente editado com sucesso');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::channel('daily')->error('Erro ao editar o cliente: ' . $exception->getMessage());
            return back()->with('error', 'Não foi possível editar o cliente');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        DB::beginTransaction();
        try {
            $client->delete();
            $client->user->delete();

            DB::commit();
            return back()->with('success', 'Cliente excluído com sucesso');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::channel('daily')->error('Erro ao excluir o cliente: ' . $exception->getMessage());
            return back()->with('error', 'Não foi possível excluir o cliente');
        }
    }
}
