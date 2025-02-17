<?php

namespace Modules\EvolutionApi\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConfigurationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'quantity_instances' => intval($this->quantity_instances),
            'is_active' => $this->is_active == 'on' ? true : false
        ]);
    }

    public function rules(): array
    {
        return [
            'identification' => 'required|string',
            'api_url' => 'required|url:https',
            'global_token_api' => 'required',
            'quantity_instances' => 'required|numeric',
            'is_active' => 'required|boolean'
        ];
    }
}