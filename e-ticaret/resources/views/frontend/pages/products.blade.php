@extends('frontend.layout.layout')

@section('content')
<style>

    [data-aos^=fade][data-aos^=fade] {
        opacity: 1!important;

    }
    </style>
<div class="bg-light py-3">
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-0"><a href="{{route('anasayfa')}}">Anasayfa</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">Mağaza</strong></div>
        </div>
    </div>
</div>

<div class="site-section">
    <div class="container">

        <div class="row mb-5">
            <div class="col-md-9 order-2">

                <div class="row">
                    <div class="col-md-12 mb-5">
                        <div class="float-md-left mb-4"><h2 class="text-black h5">Ürünler</h2></div>
                        <div class="d-flex">
                            <div class="dropdown mr-1 ml-md-auto">

                            </div>
                            <div class="btn-group">
                                <select class="form-control" id="orderList">
                                    <option class="dropdown-item" value="">Sıralama Seçiniz</option>
                                    <option class="dropdown-item" value="id-asc">A-Z ye Sırala</option>
                                    <option class="dropdown-item" value="id-desc">Z-A ya Sırala</option>
                                    <option class="dropdown-item" value="price-asc">Düşük fiyata göre sırala</option>
                                    <option class="dropdown-item" value="price-desc">Yüksek fiyata göre sıra</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        @if (session()->get('success'))
                        <div class="alert alert-success">{{(session()->get('success'))}}</div>
                        @endif
                    </div>
                </div>
                <div class="row mb-5 productContent">
                    @include('frontend.ajax.productList')
                </div>
                <div class="row paginateButtons" data-aos="fade-up">
                    {{$products->withQueryString()->links('vendor.pagination.custom')}}  {{--withQueryString filitrelenmiş olan sayfadan diğer sayfaya geçtiğimizde filtreyi bozmadan geçmemize yarar.--}}
                    {{--<div class="col-md-12 text-center">
                        <div class="site-block-27">
                            <ul>
                                <li><a href="#">&lt;</a></li>
                                <li class="active"><span>1</span></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#">4</a></li>
                                <li><a href="#">5</a></li>
                                <li><a href="#">&gt;</a></li>
                            </ul>
                        </div>
                    </div>--}}
                </div>
            </div>

            <div class="col-md-3 order-1 mb-5 mb-md-0">
                <div class="border p-4 rounded mb-4">
                    <h3 class="mb-3 h6 text-uppercase text-black d-block">Kategori</h3>
                    <ul class="list-unstyled mb-0">
                        @if (!empty($categories) && $categories->count() > 0)
                        @foreach ($categories->where('cat_ust',null) as $category)
                        <li class="mb-1"><a href="{{route($category->slug.'urunler')}}" class="d-flex"><span>{{$category->name}}</span> <span class="text-black ml-auto">({{$category->getTotalProductCount()}})</span></a></li>
                        @endforeach
                        @endif
                    </ul>
                </div>

                <div class="border p-4 rounded mb-4">
                    <div class="mb-4">
                        <h3 class="mb-3 h6 text-uppercase text-black d-block">Fiyata Göre Sırala</h3>
                        <div id="slider-range" class="border-primary"></div>
                        <input type="text" name="text" id="amount" class="form-control border-0 pl-0 bg-white" disabled="" />


                        <input type="text" name="text" id="priceBetween" class="form-control" hidden/>
                    </div>

                    <div class="mb-4">
                        <h3 class="mb-3 h6 text-uppercase text-black d-block">Boyut</h3>
                        @if (!empty($sizelists))
                        @foreach ($sizelists as $key => $size)
                        <label for="size{{$key}}" class="d-flex">
                            <input type="checkbox" id="size{{$key}}" {{isset(request()->size) && in_array($size,explode(',',request()->size)) ? 'checked' : ''}} class="mr-2 mt-1 sizeList"> <span class="text-black">{{$size}}</span>
                        </label>
                        @endforeach
                        @endif
                    </div>

                    <div class="mb-4">
                        <h3 class="mb-3 h6 text-uppercase text-black d-block">Renk</h3>
                        @if (!empty($colors))
                        @foreach ($colors as $key => $color)
                        <label for="color{{$key}}" class="d-flex">
                            <input type="checkbox" id="color{{$key}}" {{isset(request()->color) && in_array($color,explode(',',request()->color)) ? 'checked' : ''}} class="mr-2 mt-1 colorList"> <span class="text-black">{{$color}}</span>
                        </label>
                        @endforeach
                        @endif
                    </div>

                    <div class="mb-4">
                        <button class="btn btn-blok btn-primary filterBtn">Filtrele</button>
                    </div>

                </div>
            </div>
        </div>

             <div class="row">
            <div class="col-md-12">
                <div class="site-section site-blocks-2">
                    <div class="row justify-content-center text-center mb-5">
                        <div class="col-md-7 site-section-heading pt-4">
                            <h2>Kategoriler</h2>
                        </div>
                    </div>
                    <div class="row">
                        @if (!empty($fullCategory))
                        @foreach ($fullCategory->where('cat_ust',null) as $category)
                        <div class="col-sm-6 col-md-6 col-lg-4 mb-4 mb-lg-0" data-aos="fade" data-aos-delay="">
                            <a class="block-2-item" href="{{route($category->slug.'urunler')}}">
                                <figure class="image">
                                    <img src="{{asset($category->image)}}" alt="" class="img-fluid" style="height: 500px; width:350px">
                                </figure>
                                <div class="text">
                                    <h3>{{$category->name}}</h3>
                                </div>
                            </a>
                        </div>
                        @endforeach

                        @endif
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('customjs')
<script>
    var maxprice = "{{$maxprice}}";

    var defualtminprice = "{{request()->min ?? 0}}"

    var defualtmaxprice = "{{request()->max ?? $maxprice}}";

    var url = new URL(window.location.href);

    $(document).on('click', '.filterBtn', function (e){
        filtrele();
    });

    function filtrele(){
        let colorList = $(".colorList:checked").map((_,chk) => chk.value).get()
        let sizeList = $(".sizeList:checked").map((_,chk) => chk.value).get()

        if (colorList.length > 0){
            url.searchParams.set("color", colorList.join(","))
        }else{
            url.searchParams.delete('color');
        }
        if (sizeList.length > 0){
            url.searchParams.set("size", sizeList.join(","))
        }else{
            url.searchParams.delete('size');
        }



        var price = $('#priceBetween').val().split('-');
        var minPrice = price[0] === '0' ? '0' : price[0];


        url.searchParams.set("min" , minPrice)

        url.searchParams.set("max" ,price[1])


        newUrl = url.href;
        window.history.pushState({}, '', newUrl);
        location.reload();                        //filtrele butonuna basınca sayfayı yenilemeye yarar.

        $.ajax({
            headers: {
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            },
            type:"GET",
            url:newUrl,
            success: function(response){


                $('.productContent').html(response.data)
                $('.paginateButtons').html(response.paginate)
            }
        });
    }


    $(document).on('change', '#orderList', function (e){

        var order = $(this).val();

        if(order != ''){
            orderBy = order.split('-');
            url.searchParams.set("order", orderBy[0])
            url.searchParams.set("sort", orderBy[1])
        }else{
            url.searchParams.delete('order');
            url.searchParams.delete('sort');
        }
        filtrele();


    });

</script>
@endsection
