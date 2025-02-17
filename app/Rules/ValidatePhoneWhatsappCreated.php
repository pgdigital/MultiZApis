<?php

namespace App\Rules;

use App\Services\Internal\Whatsapp\WhatsappManagerService;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidatePhoneWhatsappCreated implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $whatsappService = app()->make(WhatsappManagerService::class);
        
        $exists = $whatsappService->checkWhatsappNumber(config('app.instance_primary'), preg_replace('/[^0-9]/', '', $value));

        if(!$exists) {
            $fail("O número de telefone não está registrado no WhatsApp");
        }
    }
}
