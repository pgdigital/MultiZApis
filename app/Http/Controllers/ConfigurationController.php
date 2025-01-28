<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WhatsappIntegration;
use App\Http\Requests\ConfigurationUpdate;
use App\Models\EmailTemplate;

class ConfigurationController extends Controller
{
    public function index()
    {
        return view('configuration.index');
    }

    public function emailResetPassowrd()
    {
        $template = EmailTemplate::where('type', 'reset-password')->firstOrFail();
        
        return view('configuration.email.reset-password', [
            'template' => $template
        ]);
    }
    
    public function updateEmailResetPassword(Request $request, EmailTemplate $template)
    {
        $validationData = $request->validate([
            'subject' => 'required|string',
            'content' => 'required|string'
        ]);



        try {
            $template->update($validationData);

            return redirect()->route('configuration.email.reset-password')
                ->with('success', 'Configurações do email de resetar senha atualizadas com sucesso');
        } catch (\Exception $e) {
            return redirect()->route('configuration.email.reset-password')
                ->with('error', 'Erro ao atualizar as configurações do email de resetar senha');
        }

    }

    public function evolution()
    {
        $whatsappIntegration = WhatsappIntegration::first();
        return view('configuration.evolution', [
            'whatsappIntegration' => $whatsappIntegration
        ]);
    }


    public function updateEvolution(ConfigurationUpdate $request, WhatsappIntegration $whatsappIntegration)
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
