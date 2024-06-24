<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoceRequest extends FormRequest
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
            'email' => 'required|email',
            'phone' => 'required|string',
            'company_name' => 'required|string',
            'address' => 'required|string',
            'country' => 'required|string',
            'city' => 'required|string',
            'district' => 'required|string',
            'zip_code' => 'required|string',
            'note' => 'nullable|string'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('İsim zorunlu bir alandır.'),
            'name.string' => __('İsim bir metin olmalıdır.'),
            'name.min' => __('İsim en az 3 karakterden oluşmalıdır.'),
            'email.required' => __('E-posta zorunlu bir alandır.'),
            'email.email' => __('Geçerli bir e-posta adresi girilmelidir.'),
            'phone.required' => __('Telefon zorunlu bir alandır.'),
            'phone.string' => __('Telefon bir metin olmalıdır.'),
            'company_name.string' => __('Şirket adı bir metin olmalıdır.'),
            'address.required' => __('Adres zorunlu bir alandır.'),
            'address.string' => __('Adres bir metin olmalıdır.'),                          //paranteze alma sebebim ileride dil güncellemesi yaparsam kullanmak için.
            'country.required' => __('Ülke zorunlu bir alandır.'),
            'country.string' => __('Ülke bir metin olmalırdır.'),
            'city.required' => __('Şehir zorunlu bir alandır.'),
            'city.string' => __('Şehir bir metin olmalıdır.'),
            'district.required' => __('İlçe zorunlu bir alandır.'),
            'district.string' => __('İlçe bir metin olmalırdır.'),
            'zip_code.required' => __('Posta kodu zorunlu bir alandır.'),
            'zip_code.string' => __('Posta kodu bir metin olmalırdır.'),
            'note.string' => __('Not bir metin olmalıdır.'),

            'content.required' => __('İçerik zorunludur'),
        ];
    }
}
