<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CampaignRequest extends FormRequest
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
            'status' => 'Programado'
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'client_id' => [
                Rule::requiredIf(fn() => !auth()->user()->client),
                'nullable',
                'exists:clients,id'
            ],
            'name' => 'required|string',
            'type' => 'required|in:Em massa',
            'description' => 'sometimes',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'status' => 'required'
        ];
    }
}
