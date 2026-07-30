<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

class CreateGymRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'owner_name' => ['required', 'string', 'max:255'],

            'email' => ['required', 'string', 'email', 'unique:users,email'],
            'password' => ['required', 'string', Password::min(8)->mixedCase()->numbers()->symbols()],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre del gimnasio es obligatorio.',
            'name.string' => 'El nombre del gimnasio debe ser un texto válido.',
            'name.max' => 'El nombre del gimnasio no debe superar los 255 caracteres.',
            'address.required' => 'La dirección del gimnasio es obligatoria.',
            'address.string' => 'La dirección debe ser un texto válido.',
            'address.max' => 'La dirección no debe superar los 255 caracteres.',
            'photo.image' => 'La foto debe ser un archivo válido.',
            'photo.mimes' => 'La foto debe tener formato JPG, JPEG o PNG.',
            'photo.max' => 'La foto no debe superar los 2MB.',
            'owner_name.required' => 'El nombre del propietario es obligatorio.',
            'owner_name.string' => 'El nombre del propietario debe ser un texto válido.',
            'owner_name.max' => 'El nombre del propietario no debe superar los 255 caracteres.',

            'email.required' => 'El correo del administrador es obligatorio.',
            'email.email' => 'El correo del administrador debe tener un formato válido.',
            'email.unique' => 'Este correo ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.string' => 'La contraseña debe ser un texto válido.',
            'password.min' => 'La contraseña debe tener al menos :min caracteres.',
            'password.mixed' => 'La contraseña debe incluir al menos una mayúscula y una minúscula.',
            'password.numbers' => 'La contraseña debe incluir al menos un número.',
            'password.symbols' => 'La contraseña debe incluir al menos un símbolo.',
        ];
    }
}
