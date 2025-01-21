<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Services\EvolutionService;

class ValidatePhoneWhatsappCreated implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match('/^55/', $value)) {
            $value = '55' . $value;
        }
        
        $exists = EvolutionService::checkWhatsappNumber(config('app.instance_primary'), preg_replace('/[^0-9]/', '', $value));

        if(!$exists) {
            $fail("O número de telefone não está registrado no WhatsApp");
        }
    }
}
