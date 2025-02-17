<?php

namespace App\Services\Internal\Whatsapp;

class WhatsappManagerService {

    private array $modules = [];

    public function registerModule(string $moduleClass)
    {
        $this->modules[] = $moduleClass;
    }

    public function __call($method, $arguments)
    {
        foreach($this->modules as $module) {
            $module = new $module();
            
            if(method_exists($module, $method)) {
                return call_user_func_array([$module, $method], $arguments);
            }
        }

        throw new \Exception("Método '{$method}' não encontrado em nenhum provider registrado.");
    }
}