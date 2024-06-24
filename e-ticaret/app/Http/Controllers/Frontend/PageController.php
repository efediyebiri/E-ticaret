<?php

namespace App\Http\Controllers\Frontend;

use App\Models\About;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class PageController extends Controller
{
    public function urunler(Request $request,$slug=null)
    {
        if(isset($slug)){
        $categroyModel = Category::where("slug", $slug )->first();
        $category_id = $categroyModel->id;

         }else{
            $category_id = "";
         }

         $fullCategory = Category::where("status", 1 )->get();


        $category = request()->segment(1) ?? null;
        $sizes = !empty($request->size) ? explode(',',$request->size) : null;
        $colors = !empty($request->color) ? explode(',',$request->color) : null;
        $startprice = $request->min ?? null;
        $endprice = $request->max ?? null;

        $order = $request->order ?? 'id';
        $sort = $request->sort ?? 'desc';


        $products = Product::where('status','1')->select(['id','name','slug','size','color','price','category_id','image'])
        ->where(function($q) use($sizes,$colors,$startprice,$endprice,$category_id){
            if(!empty($category_id)){
                $q->where('category_id',$category_id);
            }
            if(!empty($sizes)){
                 $q->whereIn('size',$sizes);

            }
            if(!empty($colors)){
                 $q->whereIn('color',$colors);

            }
            if(!empty($startprice) && ($endprice)){
                 //$q->whereBetween('price',[$startprice,$endprice]);

                 $q->where('price','>=',$startprice);
                 $q->where('price','<=',$endprice);

            }
            return $q;
        })
       ->orderBy($order,$sort)->paginate(21);;

        if($request->ajax()){
            $view = view('frontend.ajax.productList', compact('products'))->render();
            return response(['data' == $view, 'paginate'=>(string) $products->withQueryString()->links('vendor.pagination.custom')]);
        }


        $sizelists = Product::where('status','1')->groupBy('size')->pluck('size')->toArray();

        $colors = Product::where('status','1')->groupBy('color')->pluck('color')->toArray();


        $maxprice = Product::max('price');

        return view('frontend.pages.products',compact('products','fullCategory','maxprice','sizelists','colors'));
    }

    public function indirimdekiurunler()
    {
        return view('frontend.pages.products');
    }

    public function urundetay($slug)
    {
        $product = Product::whereSlug($slug)->where('status','1')->firstOrFail();
        $products = Product::where('id','!=',$product->id)
        ->where('category_id',$product->category_id)
        ->where('status','1')
        ->limit(6)
        ->orderBy('id','desc')
        ->get();
        return view('frontend.pages.product', compact('product','products'));
    }

    public function hakkimizda()
    {
        $about = About::where('id',1)->first();
        return view('frontend.pages.about', compact('about'));
    }

    public function iletisim()
    {
        return view('frontend.pages.contact');
    }
}
