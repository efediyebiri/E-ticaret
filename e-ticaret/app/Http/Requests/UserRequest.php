<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
    * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
    */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3',
            'email' => 'required',
            'password' =>'required',
            'is_admin' => 'integer ??',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'İsim zorunludur',
            'name.string' => 'İsim karakterlerinden oluşmalıdır.',
            'name.min' => 'İsim minimum 3 karakterden oluşmaktadır.',
            'email.required' => 'E-posta alanı zorunludur.',
            'password.required' => 'Şifre alanı zorunludur.',
        ];
    }
}
