@extends('frontend.layout.layout')

@section('content')
<div class="bg-light py-3">
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-0"><a href="{{route('anasayfa')}}">Anasayfa</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">Sepet</strong></div>
        </div>
    </div>
</div>

<div class="site-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                @if (session()->get('success'))
                <div class="alert alert-success">{{(session()->get('success'))}}</div>
                @endif

                @if (session()->get('error'))
                <div class="alert alert-danger">{{(session()->get('error'))}}</div>
                @endif
            </div>
        </div>
        <div class="row mb-5">
            <div class="col-md-12 site-blocks-table">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="product-thumbnail">Resim</th>
                            <th class="product-name">Ürün</th>
                            <th class="product-price">Fiyat</th>
                            <th class="product-price">Kdv</th>
                            <th class="product-quantity">Adet</th>
                            <th class="product-total">Tutar</th>
                            <th class="product-remove">Sil</th>
                        </tr>
                    </thead>
                    <tbody>

                        @if ($cartItem)
                        @foreach ($cartItem as $key => $cart)
                        <form action="{{route('sepet.newqty')}}">
                            <tr class="orderitem" id="total_row_product_{{$key}}" data-id="{{$key}}">
                                <td class="product-thumbnail">
                                    <img src="{{asset($cart['image'])}}" alt="Image" class="img-fluid">
                                </td>
                                <td class="product-name">
                                    <h2 class="h5 text-black">{{$cart['name'] ?? ''}}</h2>
                                    Beden: {{($cart['size']) ?? ''}}
                                </td>
                                <td>{{$cart['price']}} ₺</td>
                                <td>{{$cart['kdv'] ?? 0}} %</td>
                                <td>

                                    <div class="input-group mb-3" style="max-width: 120px; ">
                                        <div class="input-group-prepend" >
                                            <button class="btn btn-outline-primary js-btn-minus decreaseBtn" data-id="{{$key}}" type="button">&minus;</button>
                                        </div>
                                        <input type="text" class="form-control text-center qtyItem" id="qtyid_{{$key}}"   value="{{$cart['qty']}}" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-primary js-btn-plus increaseBtn" data-id="{{$key}}"  type="button">&plus;</button>
                                        </div>
                                    </div>

                                </td>
                            </form>
                            @php
                            $kdvOrani = $cart['kdv'] ?? 0;
                            $fiyat = $cart['price'];
                            $adet = $cart['qty'];

                            $kdvtutar = ($fiyat * $adet) * ($kdvOrani / 100);
                            $toplamTutar = $fiyat * $adet + $kdvtutar;
                            @endphp
                            <td class="itemTotal"> <div id="total_price_product_{{$key}}">{{$toplamTutar}} ₺</div></td>

                            <td>
                                <form action="{{route('sepet.remove')}}" method="POST">
                                    @csrf

                                    @php
                                    $sifrele = sifrele($key);
                                    @endphp

                                    <input type="hidden" name="product_id" value="{{$sifrele}}">
                                    <button type="submit" class="btn btn-primary btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                        <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5"/>
                                    </svg></button>
                                </form>
                            </td>
                        </tr>

                        @endforeach
                        @endif

                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <form action="{{route('coupon.check')}}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <label class="text-black h4" for="coupon">İndirim Kuponu</label>
                            <p>İndirim kupon kodunuz var ise girebilirsiniz.</p>
                        </div>
                        <div class="col-md-8 mb-3 mb-md-0">
                            <input type="text" class="form-control py-3" id="coupon" value="{{session()->get('coupon_code') ?? ''}}" name="coupon_name" placeholder="İndirim Kupon Kodu">
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary btn-sm">Kupon Kodu Onayla</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-6 pl-5">
                <div class="row justify-content-end">
                    <div class="col-md-7">
                        <div class="row">
                            <div class="col-md-12 text-right border-bottom mb-5">
                                <h3 class="text-black h4 text-uppercase">Toplam Tutar</h3>
                            </div>
                        </div>

                        <div class="row mb-5">
                            <div class="col-md-6">
                                <span class="text-black">Tutar</span>
                            </div>
                            <div class="col-md-6 text-right">
                                <strong class="text-black newTotalPrice">{{session()->get('total_price') ?? ''}} ₺</strong>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <button class="btn btn-primary btn-lg py-3 btn-block paymentButton">Ödemeyi Tamamla</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('customjs')
<script>
    $(document).on('click','.paymentButton', function(e){
        var url = "{{route('sepet.form')}}";

        @if(!empty(session()->get('cart')))
        window.location.href = url;
        @endif
    });

    $(document).on('click','.decreaseBtn', function(e){
        var urun = $(this).attr("data-id");
        var qty = $("#qtyid_"+urun).val();

        $('.orderItem').removeClass('selected');
        $(this).closest('.orderItem').addClass('selected');
        sepetUpdate(urun,qty);

    });

    $(document).on('click','.increaseBtn', function(e){
        var urun = $(this).attr("data-id");
        var qty = $("#qtyid_"+urun).val();

        $('.orderItem').removeClass('selected');
        $(this).closest('.orderItem').addClass('selected');
        sepetUpdate(urun,qty);
    });


    function sepetUpdate(urun,qty){
        var product_id = urun;
        var qty = qty;

        $.ajax({
            headers:{
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            },
            type:"POST",
            url:"{{route('sepet.newqty')}}",
            data:{
                product_id:product_id,
                qty:qty,

            },
            success: function (response){
                $('.selected').find('.itemTotal').text(response.itemTotal+' ₺');
                if(response.silindi){
                    $("#total_row_product_" +product_id).remove();
                }

                $("#total_price_product_" + product_id).html(response.itemTotal+ ' ₺');
                $('.newTotalPrice').text(response.totalPrice + ' ₺');


                console.log(response);
            }
        });
    }



</script>

@endsection
