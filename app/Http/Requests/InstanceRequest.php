<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ValidatePhoneWhatsappCreated;

class InstanceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation()
    {
        if(auth()->user()->client) {
            $this->merge([
                'client_id' => auth()->user()->client->id
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'client_id' => 'required|exists:clients,id',
            'name' => 'required|string|max:255|unique:instances,name',
            'phone' => [
                'required',
                'string',
                'unique:instances,phone',
                new ValidatePhoneWhatsappCreated()
            ],
        ];
    }
}
