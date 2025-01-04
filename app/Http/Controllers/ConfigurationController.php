<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WhatsappIntegration;
use App\Http\Requests\ConfigurationUpdate;

class ConfigurationController extends Controller
{
    public function index()
    {
        $whatsappIntegration = WhatsappIntegration::first();
        return view('configuration.evolution', [
            'whatsappIntegration' => $whatsappIntegration
        ]);
    }


    public function update(ConfigurationUpdate $request, WhatsappIntegration $whatsappIntegration)
    {
        $validationData = $request->validated();

        try {
            $whatsappIntegration->update($validationData);

            return redirect()->route('configuration.evolution')
                ->with('success', 'Configurações atualizadas com sucesso');
        } catch (\Exception $e) {
            return redirect()->route('configuration.evolution')
                ->with('error', 'Erro ao atualizar as configurações');
        }
    }
}
