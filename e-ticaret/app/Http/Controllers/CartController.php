<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Coupon;
use App\Models\Invoice;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{

    public function index() {
        $cartItem = $this->sepetList();

        return view('frontend.pages.cart', compact('cartItem'));
    }

    public function sepetList() {
        $cartItem = session()->get('cart') ?? [];
        $totalPrice = 0;

        foreach ($cartItem as $cart){
            $kdvOrani = $cart['kdv'] ?? 0;
            $kdvtutar = ($cart['price'] * $cart['qty']) * ($kdvOrani / 100);
            $toplamTutar = $cart['price'] * $cart['qty'] + $kdvtutar;
            $totalPrice += $toplamTutar;
        }

        if(session()->get('coupon_code') && $totalPrice != 0){
            $kupon = Coupon::where('name',session()->get('coupon_code'))->where('status','1')->first();
            $kuponprice = $kupon->price ?? 0;
            $newtotalPrice = $totalPrice - $kuponprice;
        }else{
            $newtotalPrice = $totalPrice;
        }

        session()->put('total_price',$newtotalPrice);

        // if(count(session()->get('cart')) == 0){
            //     session()->forget('coupon_code');
            // }

            return $cartItem;
        }



        public function sepetform() {
            $cartItem = $this->sepetList();
            return view('frontend.pages.cartform', compact('cartItem'));
        }

        public function add(Request $request) {
            $productID = sifrelecoz($request->product_id);
            $cartItem = session('cart',[]);
            $qty = $request->qty ?? 1;
            $size = $request->size;


            $urun = Product::find($productID);

            if(!$urun){
                return back()->withError('Ürün Bulunamadı!');
            }
            $cartItem = session('cart',[]);

            if(array_key_exists($productID,$cartItem)){
                $cartItem[$productID]['qty'] += $qty;
            }
            else{
                $cartItem[$productID] = [
                    'image'=>$urun->image,
                    'name'=>$urun->name,
                    'price' => $urun->price,
                    'qty' => $qty,
                    'kdv' => $urun->kdv,
                    'size' => $size,
                ];
            }
            session(['cart' => $cartItem]);




            if($request->ajax()){
                return response()->json(['sepetCount'=>count(session()->get('cart')), 'message'=>'Ürün sepete Eklendi!']);
                // return response()->json(['Sepet Güncellendi!']);
            }
            return back()->withSuccess('Ürün Sepete Eklendi!');
        }


        public function newqty(Request $request){

            $productID = $request->product_id;
            $qty = $request->qty ?? 1;
            $itemtotal = 0;
            $total_price = 0;
            $sepet_tutar = session()->get('total_price');
            $urun = Product::find($productID);
            if(!$urun){
                return response()->json('Ürün Bulunamadı!');
            }
            $cartItem = session('cart',[]);

            if(array_key_exists($productID,$cartItem)){
                $cartItem[$productID]['qty']  = $qty;
                if($qty == 0 || $qty < 0){


                    return response()->json(['silindi'=>$productID,  'message'=>'Sepetten Silindi']);

                    unset($cartItem[$productID]);

                }
                $itemtotal = $urun->price * $qty;
                $total_price = $itemtotal;

            }
            session(['cart'=>$cartItem]);


            if($request->ajax()){
                return response()->json(['itemTotal'=>$itemtotal, 'totalPrice'=>$total_price, 'message'=>'Sepet Güncellendi']);
            }

        }

        public function remove(Request $request) {

            $productID = sifrelecoz($request->product_id);
            $cartItem = session('cart',[]);
            if(array_key_exists($productID,$cartItem)){
                unset($cartItem[$productID]);
            }
            session(['cart'=>$cartItem]);

            if(count(session()->get('cart')) == 0){
                session()->forget('coupon_code');
            }

            if($request->ajax()){
                return response()->json(['sepetCount'=>count(session()->get('cart')), 'message'=>'Ürün Sepetten Kaldırıldı']);
                // return response()->json(['Sepet Güncellendi!']);
            }

            return back()->withSuccess('Başarıyla Sepetten Kaldırıldı!');
        }



        public function couponcheck(Request $request) {



            $kupon = Coupon::where('name',$request->coupon_name)->where('status','1')->first();

            if(empty($kupon)){
                return back()->withError('Kupon Bulunamadı!')->with('newtotalPrice');
            }
            $kuponcode = $kupon->name ?? '';
            session()->put('coupon_code',$kuponcode);

            $kuponprice = $kupon->price ?? 0;

            session()->put('coupon_price',$kuponprice);
            $this->sepetList();


            return back()->withSuccess('İndirim Kuponu Uygulandı!');
        }

        function generateKod(){
            $siparisno = generateOTP(7);
            if($this->barcodeExists($siparisno)){
                return $this->generateKod();
            }

            return $siparisno;
        }

        function barcodeExists($siparisno){
            return Invoice::where('order_no',$siparisno)->exists();
        }


        public function cartSave(Request $request) {
            $request->all();

            $request->validate([
                'name' => 'required|string|min:3',
                'email' => 'required|email',
                'phone' => 'required|string',
                'company_name' => '',
                'address' => 'required|string',
                'country' => 'required|string',
                'city' => 'required|string',
                'district' => 'required|string',
                'zip_code' => 'required|string',
                'note' => 'nullable|string'
            ],[
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
            ]);

            $invoices = Invoice::create([
                "user_id" => auth()->user()->id ?? null,
                "order_no" =>$this->generateKod(),
                "country" =>$request->country,
                "name" =>$request->name,
                "company_name" =>$request->company_name ?? null,
                "address" =>$request->address ?? null,
                "city" =>$request->city ?? null,
                "district" =>$request->district ?? null,
                "zip_code" =>$request->zip_code ?? null,
                "email" =>$request->email ?? null,
                "phone" =>$request->phone ?? null,
                "note" =>$request->note ?? null,
            ]);


            $cart = session()->get('cart') ?? [];
            foreach($cart as $key => $item){
                Order::create([
                    'order_no' => $invoices->order_no,
                    'product_id' => $key,
                    'name' => $item['name'],
                    'price' => $item['price'],
                    'qty' => $item['qty'],
                    'kdv' => $item['kdv'] ?? '',
                ]);
            }




            // foreach ($cart as $key => $item) {
                //     // Her bir öğe için bir sipariş oluştur
                //     $orders = new Order();
                //     $orders->order_no = $invoices->order_no;
                //     $orders->product_id = $key;
                //     $orders->name = $item['name'];
                //     $orders->price = $item['price'];
                //     $orders->qty = $item['qty'];
                //     $orders->kdv = $item['kdv'];

                //     // Siparişi kaydet
                //     $orders->create();
                // }
                session()->forget('cart');
                return redirect()->route('anasayfa')->withSuccess('Alışveriş Başarıyla Tamamlandı.');
            }
        }
