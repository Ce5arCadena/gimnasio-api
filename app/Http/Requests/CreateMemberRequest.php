<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateMemberRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'join_date' => ['required', 'date_format:Y-m-d', 'before_or_equal:today'],
            'initial_weight' => ['required', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre del socio es obligatorio.',
            'name.string' => 'El nombre del socio debe ser un texto válido.',
            'name.max' => 'El nombre del socio no debe superar los 255 caracteres.',

            'phone.required' => 'El teléfono es obligatorio.',
            'phone.string' => 'El teléfono debe ser un texto válido.',
            'phone.max' => 'El teléfono no debe superar los 20 caracteres.',

            'join_date.required' => 'La fecha de ingreso es obligatoria.',
            'join_date.date_format' => 'La fecha de ingreso debe ser una fecha válida. AAAA-MM-DD',
            'join_date.before_or_equal' => 'La fecha de ingreso no puede ser una fecha mayor a hoy.',

            'initial_weight.required' => 'El peso inicial es obligatorio.',
            'initial_weight.integer' => 'El peso inicial debe ser un número entero.',
            'initial_weight.min' => 'El peso inicial debe ser mayor a :min.',
        ];
    }
}
