<?php

namespace Modules\EvolutionApi\App\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\EvolutionApi\App\Http\Requests\ConfigurationRequest;
use Modules\EvolutionApi\App\Models\Configuration;

class EvolutionApiController extends Controller
{
    public function index()
    {
        $configurations = Configuration::query()->paginate(10);
        return view('evolutionapi::index', [
            'configurations' => $configurations
        ]);
    }

    public function create()
    {
        return view('evolutionapi::create');
    }

    public function store(ConfigurationRequest $request)
    {
        $validationData = $request->validated();

        try {
            Configuration::query()->create($validationData);

            return redirect()->route('integrations.evolutionapi.index')
                ->with('success', "Você criou uma configuração para EvolutionAPI com sucesso!");
        } catch (\Exception $exception) {
            return redirect()->route('integrations.evolutionapi.index')
                ->with('success', "Não foi possível de criar uma configuração para EvolutionAPI com sucesso!");
        }
    }

    public function edit(Configuration $configuration)
    {
        return view('evolutionapi::edit', [
            'configuration' => $configuration
        ]);
    }

    public function update(ConfigurationRequest $request, Configuration $configuration)
    {
        $validationData = $request->validated();

        try {
            $configuration->update($validationData);
            return redirect()->route('integrations.evolutionapi.index')
            ->with('success', "Você editou uma configuração para EvolutionAPI com sucesso!");
        } catch (\Exception $exception) {
            return redirect()->route('integrations.evolutionapi.index')
                ->with('success', "Não foi possível de editar uma configuração para EvolutionAPI com sucesso!");
        }
    }

    public function destroy(Configuration $configuration)
    {
        try {
            $configuration->delete();
            return redirect()->route('integrations.evolutionapi.index')
            ->with('success', "Você excluíu uma configuração para EvolutionAPI com sucesso!");
        } catch (\Exception $exception) {
            return redirect()->route('integrations.evolutionapi.index')
                ->with('success', "Não foi possível de excluir uma configuração para EvolutionAPI com sucesso!");
        }
    }
}
