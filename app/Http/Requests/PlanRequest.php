<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->can('create', Plan::class);
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'is_active' => $this->is_active == 'on',
            'price' => str_replace(',','.', str_replace('.', '', $this->price))
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
            'name' => 'required|string',
            'quantity_instance' => 'required|integer',
            'quantity_messages' => 'required|integer',
            'price' => 'required|numeric',
            'is_active' => 'required|boolean'
        ];
    }
}
