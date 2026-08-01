<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class UpdateProfileRequest extends FormRequest
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
            'current_password' => ['required', 'string'],
            'email' => ['sometimes', 'required', 'string', 'email', Rule::unique('users', 'email')->ignore($this->user()->id)],
            'password' => ['sometimes', 'required', 'string', 'confirmed', Password::min(8)->mixedCase()->numbers()->symbols()],
        ];
    }

    public function messages(): array
    {
        return [
            'current_password.required' => 'Debes ingresar tu contraseña actual para confirmar el cambio.',
            'current_password.string' => 'La contraseña actual debe ser un texto válido.',

            'email.required' => 'El correo no puede quedar vacío.',
            'email.email' => 'El correo debe tener un formato válido.',
            'email.unique' => 'Este correo ya está en uso por otra cuenta.',

            'password.required' => 'La contraseña no puede quedar vacía.',
            'password.string' => 'La contraseña debe ser un texto válido.',
            'password.confirmed' => 'La confirmación de contraseña no coincide.',
            'password.min' => 'La contraseña debe tener al menos :min caracteres.',
            'password.mixed' => 'La contraseña debe incluir al menos una mayúscula y una minúscula.',
            'password.numbers' => 'La contraseña debe incluir al menos un número.',
            'password.symbols' => 'La contraseña debe incluir al menos un símbolo.',
        ];
    }
}
