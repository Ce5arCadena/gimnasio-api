<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class UpdateMemberRequest extends FormRequest
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
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'phone' => ['sometimes', 'required', 'string', 'max:20'],
            'join_date' => ['sometimes', 'required', 'date', 'before_or_equal:today'],
            'initial_weight' => ['sometimes', 'required', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre del socio no puede quedar vacío.',
            'name.string' => 'El nombre del socio debe ser un texto válido.',
            'name.max' => 'El nombre del socio no debe superar los 255 caracteres.',

            'phone.required' => 'El teléfono no puede quedar vacío.',
            'phone.string' => 'El teléfono debe ser un texto válido.',
            'phone.max' => 'El teléfono no debe superar los 20 caracteres.',

            'join_date.required' => 'La fecha de ingreso no puede quedar vacía.',
            'join_date.date' => 'La fecha de ingreso debe ser una fecha válida.',
            'join_date.before_or_equal' => 'La fecha de ingreso no puede ser una fecha futura.',

            'initial_weight.required' => 'El peso inicial no puede quedar vacío.',
            'initial_weight.integer' => 'El peso inicial debe ser un número entero.',
            'initial_weight.min' => 'El peso inicial debe ser mayor a :min.',
        ];
    }
}
