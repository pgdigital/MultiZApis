<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WhatsappIntegration;
use App\Http\Requests\ConfigurationUpdate;
use App\Models\Configuration;
use App\Models\EmailTemplate;

class ConfigurationController extends Controller
{
    public function index()
    {
        $configuration = Configuration::firstOrFail();
        return view('configuration.index', [
            'configuration' => $configuration
        ]);
    }

    public function update(Request $request, Configuration $configuration)
    {
        $validationData = $request->validate([
            'name' => 'required|string',
            'logo_path' => 'sometimes|nullable|image',
            'favicon_path' => 'sometimes|nullable|image',
            'home_image_path' => 'sometimes|nullable|image'
        ]);

        try {
            if(isset($validationData['logo_path']) && $validationData['logo_path']->isValid()) {
                if(config('filesystems.default') == 'public') {
                    $validationData['logo_path'] = 'storage/'.$validationData['logo_path']->store('images');
                } else {
                    $validationData['logo_path'] = $validationData['logo_path']->store('images');
                }
            }

            if(isset($validationData['favicon_path']) && $validationData['favicon_path']->isValid()) {
                if(config('filesystems.default') == 'public') {
                    $validationData['favicon_path'] = 'storage/'.$validationData['favicon_path']->store('images');
                } else {
                    $validationData['favicon_path'] = $validationData['favicon_path']->store('images');
                }
            }

            if(isset($validationData['home_image_path']) && $validationData['home_image_path']->isValid()) {
                if(config('filesystems.default') == 'public') {
                    $validationData['home_image_path'] = 'storage/'.$validationData['home_image_path']->store('images');
                } else {
                    $validationData['home_image_path'] = $validationData['home_image_path']->store('images');
                }
            }

            $configuration->update($validationData);

            return redirect()->route('configuration.index')
                ->with('success', 'Configurações atualizadas com sucesso');
        } catch (\Exception $e) {
            dd($e);
            return redirect()->route('configuration.index')
                ->with('error', 'Erro ao atualizar as configurações');
        }
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
