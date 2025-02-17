<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Exception;
use Illuminate\Http\Request;

class IntegrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $modules = Module::paginate(10);
        return view('integration.index', [
            'modules' => $modules
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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

    public function toggleModule(Module $module)
    {
        try {
            if(!$module->enabled) {
                $module->enable();
                $decision = "Ativado";
            } else {
                $module->disable();
                $decision = "Desativado";
            }

            return redirect()->route('integrations.index')
                ->with('success', "O Plugin {$module->name} foi {$decision} com sucesso!");
        } catch(Exception $exception) {
            dd($exception);
            return redirect()->route('integrations.index')
            ->with('error', 'Erro ao atualizar as configurações');
        }
    }
}
