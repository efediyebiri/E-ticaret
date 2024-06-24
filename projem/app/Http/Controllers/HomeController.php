<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
       return view("front.index"); 
    }

    public function about()
    {
       return redirect(route("contact"));                 //redirect yönledirme demek burada da about a tıkladığımızda contact sayfasına bizi atmayı sağlıyor.
       //return redirect()->route("contact");             //üçüde aynı işlemeye yarıyor.                                 
       //return Redirect::route("contact");
    }

    public function contact()
    {
       return view("front.contact"); 
    }
    
    public function showForm()
    {
      return view ("front.contact");
    }

   
}


