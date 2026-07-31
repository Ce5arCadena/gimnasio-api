<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateGymRequest extends FormRequest
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
            'address' => ['sometimes', 'required', 'string', 'max:255'],
            'photo' => ['sometimes', 'nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'owner_name' => ['sometimes', 'required', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre del gimnasio no puede quedar vacío.',
            'name.string' => 'El nombre del gimnasio debe ser un texto válido.',
            'name.max' => 'El nombre del gimnasio no debe superar los 255 caracteres.',

            'address.required' => 'La dirección no puede quedar vacía.',
            'address.string' => 'La dirección debe ser un texto válido.',
            'address.max' => 'La dirección no debe superar los 255 caracteres.',

            'photo.image' => 'La foto debe ser un archivo válido.',
            'photo.mimes' => 'La foto debe tener formato JPG, JPEG o PNG.',
            'photo.max' => 'La foto no debe superar los 2MB.',

            'owner_name.required' => 'El nombre del propietario no puede quedar vacío.',
            'owner_name.string' => 'El nombre del propietario debe ser un texto válido.',
            'owner_name.max' => 'El nombre del propietario no debe superar los 255 caracteres.',
        ];
    }
}
