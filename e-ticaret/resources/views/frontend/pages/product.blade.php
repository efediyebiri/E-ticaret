@extends('frontend.layout.layout')
@section('content')
<div class="bg-light py-3">
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-0"><a href="{{route('anasayfa')}}">Anasayfa</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">Ürün</strong></div>
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
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <img src="{{asset($product->image)}}"  alt="Image" style="height: 500px; width:400px" class="img-fluid">
            </div>
            <div class="col-md-6">
                <h2 class="text-black">{{$product->name ?? '' }}</h2>
                {!! $product->content !!}
                <p><strong class="text-primary h4">{{number_format($product->price,2)}} ₺</strong></p>
                <form action="{{route('sepet.add', $product->id)}}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{$product->id}}">
                    <div class="mb-1 d-flex">
                        <label for="option-xs" class="d-flex mr-3 mb-3">
                            <span class="d-inline-block mr-2" style="top:-2px; position: relative;"><input type="radio" id="option-xs" name="size" {{$product->size == 'XS' ? 'checked' : ''}} value="XS"></span> <span class="d-inline-block text-black">XS</span>
                        </label>
                        <label for="option-s" class="d-flex mr-3 mb-3">
                            <span class="d-inline-block mr-2" style="top:-2px; position: relative;"><input type="radio" id="option-s" name="size" {{$product->size == 'S' ? 'checked' : ''}} value="S"></span> <span class="d-inline-block text-black">S</span>
                        </label>
                        <label for="option-m" class="d-flex mr-3 mb-3">
                            <span class="d-inline-block mr-2" style="top:-2px; position: relative;"><input type="radio" id="option-m" name="size" {{$product->size == 'M' ? 'checked' : ''}} value="M"></span> <span class="d-inline-block text-black">M</span>
                        </label>
                        <label for="option-l" class="d-flex mr-3 mb-3">
                            <span class="d-inline-block mr-2" style="top:-2px; position: relative;"><input type="radio" id="option-l" name="size" {{$product->size == 'L' ? 'checked' : ''}} value="L"></span> <span class="d-inline-block text-black">L</span>
                        </label>
                        <label for="option-xxl" class="d-flex mr-3 mb-3">
                            <span class="d-inline-block mr-2" style="top:-2px; position: relative;"><input type="radio" id="option-xxl" name="size" {{$product->size == 'XXL' ? 'checked' : ''}} value="XXL"></span> <span class="d-inline-block text-black">XXL</span>
                        </label>
                    </div>
                    <form action="{{route('sepet.add')}}" method="POST">
                        @csrf
                        @php
                        $sifrele = sifrele($product->id);
                        @endphp
                        <input type="hidden" name="product_id" value="{{$sifrele}}">
                        <p><button type="submit" class="buy-now btn btn-sm btn-primary">Sepete Ekle</button></p>
                    </form>
                </form>
            </div>
        </div>
    </div>
</div>


{{-- @if (!empty($products) && $products->count() > 0)
    <div class="site-section block-3 site-bloks-2 bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-7 site-section-heading text-center pt-4">
                    <h2>Diğer Ürünlerimiz</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="nonloop-block-3 owl-carousel">
                        @foreach ($products as $item)
                        <div class="item">
                            <div class="block-4 text-center">
                                <figure class="block-4-image">
                                    <img src="{{asset($item->image)}}" alt="{{$item->name}}" class="img-fuild">
                                </figure>
                                <div class="block-4-text p-4">
                                    <h3><a href="{{route('urundetay', $item->slug)}}">{{$item->name}}</a></h3>
                                    <p class="text-primary font-weight-bold">{{$item->price}} ₺</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endif--}}
    @endsection

