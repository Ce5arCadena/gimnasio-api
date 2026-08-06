<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class CreatePlanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required', 
                'string', 
                'max:255',
                Rule::unique('plans', 'name')->where('gym_id', auth()->user()->gym_id)
            ],
            'duration_days' => ['required', 'integer', 'min:1'],
            'price' => ['required', 'integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre del plan es obligatorio.',
            'name.string' => 'El nombre del plan debe ser un texto válido.',
            'name.max' => 'El nombre del plan no debe superar los 255 caracteres.',
            'name.unique' => 'Ya existe un plan con este nombre en tu gimnasio.',

            'duration_days.required' => 'La duración del plan es obligatoria.',
            'duration_days.integer' => 'La duración debe ser un número entero.',
            'duration_days.min' => 'La duración debe ser mayor a :min día.',

            'price.required' => 'El precio del plan es obligatorio.',
            'price.integer' => 'El precio debe ser un número entero.',
            'price.min' => 'El precio no puede ser negativo.',
        ];
    }
}
