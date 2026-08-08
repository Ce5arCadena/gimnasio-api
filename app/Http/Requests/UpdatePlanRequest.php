<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class UpdatePlanRequest extends FormRequest
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
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('plans', 'name')
                    ->where('gym_id', auth()->user()->gym_id)
                    ->ignore($this->route('plan')),
            ],
            'duration_days' => ['sometimes', 'required', 'integer', 'min:1'],
            'price' => ['sometimes', 'required', 'integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre del plan no puede quedar vacío.',
            'name.string' => 'El nombre del plan debe ser un texto válido.',
            'name.max' => 'El nombre del plan no debe superar los 255 caracteres.',
            'name.unique' => 'Ya existe un plan con este nombre en tu gimnasio.',

            'duration_days.required' => 'La duración del plan no puede quedar vacía.',
            'duration_days.integer' => 'La duración debe ser un número entero.',
            'duration_days.min' => 'La duración debe ser mayor a :min día.',

            'price.required' => 'El precio del plan no puede quedar vacío.',
            'price.integer' => 'El precio debe ser un número entero.',
            'price.min' => 'El precio no puede ser negativo.',
        ];
    }
}
