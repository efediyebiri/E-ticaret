<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ContentFormRequest;

class AjaxController extends Controller
{
    public function iletisimkaydet(ContentFormRequest $request)
    {
       /*$data = $request->all();
       $data['ip'] = request()->ip();*/


        //Burada zorunlu doldurmamız gereken alanların kodları hekleyerek zorunluluğunun kaldırılması durumu için güvenlik önmeli aldım.
        /* $validationdata = $request->validate([
            'name' => 'required|string|min:3',
            'email' => 'required|email',
            'subject' => 'required',
            'message' =>'required'
        ],[
            'name.required' => 'İsim soyisim zorunludur',
            'name.string' => 'İsim soyisim karakterlerinden oluşmalıdır.',                                burada olması daha düzensizdi burasını contentformrequestin içine aldım.
            'name.min' => 'İsim soyisim minimum 3 karakterden oluşmaktadır.',
            'email.required' => 'E-posta zorunludur.',
            'email.email' => 'Geçersiz bir email adresi girdiniz.',
            'subject.required' => 'Konu kısmı boş geçilmez.',
            'message.required' => 'Mesaj kısmı boş geçilemez.',
        ]);*/


        $newdata = [
            'name'=>Str::title($request->name),
            'email'=>$request->email,
            'subject'=>$request->subject,
            'message'=>$request->message,
            'ip'=>request()->ip(),
        ];



       $sonkaydedilen = Contact::create($newdata);
       return back()->withSuccess('Başarıyla Gönderildi',);
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('anasayfa');
    }


}
