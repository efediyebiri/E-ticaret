<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContentFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;  //bu her zaman true olmak zorunda sebebide çalışması için.
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
            'email' => 'required|email',
            'subject' => 'required',
            'message' =>'required'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'İsim soyisim zorunludur',
            'name.string' => 'İsim soyisim karakterlerinden oluşmalıdır.',
            'name.min' => 'İsim soyisim minimum 3 karakterden oluşmaktadır.',
            'email.required' => 'E-posta zorunludur.',
            'email.email' => 'Geçersiz bir email adresi girdiniz.',
            'subject.required' => 'Konu kısmı boş geçilmez.',
            'message.required' => 'Mesaj kısmı boş geçilemez.',
        ];
    }
}
