@extends('backend.layout.app')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                <h4 class="card-title">Ürünler</h4>
                <p class="card-description">
                        <a href="{{route('panel.product.create')}}" class="btn btn-primary">Yeni</a>
                </p>

                    @if (session()->get('success'))
                    <div class="alert alert-success">
                        {{session()->get('success')}}
                    </div>
                @endif

                    <div class="table-responsive">
                        <table class="table">
                        <thead>
                            <tr>
                            <th>Resim</th>
                            <th>Başlık</th>
                            <th>Slogan</th>
                            <th>Link</th>
                            <th>Durum</th>
                            <th>Düzenle</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!empty($products) && $products->count() > 0)
                                @foreach ($products as $item)
                                <tr class="item" item-id="{{$item->id}}">
                                    <td class="py-1">
                                        <img src={{asset($item->image)}} alt="image"/>
                                    </td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->category->name ?? ''}}</td>
                                <td>{{$item->category->link ?? ''}}</td>
                                <td>
                                    {{--<label class="badge badge-{{$slider->status == 1 ? 'success' : 'danger'}}">{{$slider->status == 1 ? 'Aktif' : 'Pasif'}}</label>--}}
                                    <div class="checkbox">
                                        <label>
                                          <input type="checkbox" class="durum"  data-on="Aktif" data-off="Pasif" data-onstyle="success" {{$item->status == '1' ? 'checked' : ''}} data-toggle="toggle"></label>
                                      </div>
                                </td>
                                <td class="d-flex">
                                    <a href="{{route('panel.product.edit' , $item->id)}}" class="btn btn-info mr-2">Düzenle</a>

                                    <button type="button" class="silBtn btn btn-danger">Sil</button>

                                </td>
                                </tr>
                                @endforeach
                            @endif
                        </tbody>
                        </table>
                    </div>

                    {{$products->links('pagination::custom')}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('custom.js')
<script>
    $(document).on('change', '.durum', function(e){

        id = $(this).closest('.item').attr('item-id');             //checkbox kılasını bul item idsini al.
        statu = $(this).prop('checked');                               //aktifmi pasifmi olduğunu algılıyor.
        $.ajax({
            headers: {
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            },
            type:"POST",
            url:"{{route('panel.product.status')}}",
            data: {
                id:id,
                statu:statu           //controllerde hangi isimle yakalayacaksam onları veriyorum.Bi veri yakalanmak istediğinde kullanılır.
            },
            success: function(response) {
                if(response.status == "true"){
                    alertify.success("Durum Aktif Edildi");
                }else{
                    alertify.error("Durum Pasif Edildi");
                }
            }
        });
    });


    $(document).on('click', '.silBtn', function(e){
        e.preventDefault();

        var item = $(this).closest('.item');
        id = item.attr('item-id');
        alertify.confirm("Silmek İstediğine Eminmisin ?","Silmek İstediğine Eminmisin ?",
            function(){
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                    },
                    type:"DELETE",
                    url:"{{route('panel.product.destroy')}}",
                    data: {
                        id:id,
                    },
                    success: function(response) {
                        if(response.error == false){
                            item.remove();
                            alertify.success(response.message);
                        }else{
                            alertify.error("Bir Hata Oluştu");
                        }
                    }
                });
            },
            function(){
                alertify.error('İptal Edildi');
            });
                });

</script>
@endsection
