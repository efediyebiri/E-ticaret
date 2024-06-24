<?php

namespace App\Http\Controllers\Frontend;

use App\Models\About;
use App\Models\Slider;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Session\Session;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class PageHomeController extends Controller
{
    public function anasayfa(Request $request)
    {

        $slider = Slider::where('status','1')->first();
        $title = "Anasayfa";


        $about = About::where('id',1)->first();

        $lastproducts = Product::where('status','1')
        ->select(['id','name','slug','size','color','price','category_id','image'])
        ->with('category')
        ->orderBy('id','desc')
        ->limit(10)
        ->get();
        return view('frontend.pages.index' , compact('slider','title','about','lastproducts'));
    }
}
