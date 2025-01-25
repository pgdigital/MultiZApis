<?php

namespace App\Http\Requests;

use App\Models\Client;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->can('create', Client::class);
    }

    public function prepareForValidation()
    {
        $this->merge([
            'status' => "Ativo"
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
            'plan_id' => 'required|exists:plans,id',
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email:dns,rfc',
                'max:255',
                Rule::unique('users')->ignore($this->client?->user_id)
            ],
            'phone' => 'required|string|max:255',
            'status' => 'required'
        ];
    }
}
