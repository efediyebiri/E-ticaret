@extends('backend.layout.app')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                <h4 class="card-title">Basic Table</h4>
                <p class="card-description">
                        <a href="{{route('panel.slider.create')}}" class="btn btn-primary">Yeni</a>
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
                            @if (!empty($sliders) && $sliders->count() > 0)
                                @foreach ($sliders as $slider)
                                <tr class="item" item-id="{{$slider->id}}">
                                    <td class="py-1">
                                        <img src="jpg_44-2.jpg" alt="image"/>
                                    </td>
                                <td>{{$slider->name}}</td>
                                <td>{{$slider->content ?? ''}}</td>
                                <td>{{$slider->link}}</td>
                                <td>
                                    {{--<label class="badge badge-{{$slider->status == 1 ? 'success' : 'danger'}}">{{$slider->status == 1 ? 'Aktif' : 'Pasif'}}</label>--}}
                                    <div class="checkbox">
                                        <label>
                                          <input type="checkbox" class="durum"  data-on="Aktif" data-off="Pasif" data-onstyle="success" {{$slider->status == '1' ? 'checked' : ''}} data-toggle="toggle"></label>
                                      </div>
                                </td>
                                <td class="d-flex">
                                    <a href="{{route('panel.slider.edit' , $slider->id)}}" class="btn btn-info mr-2">Düzenle</a>

                                    {{--<form action="{{route('panel.slider.destroy' , $slider->id)}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Sil</button>
                                    </form>--}}

                                    <button type="button" class="silBtn btn btn-danger">Sil</button>

                                </td>
                                </tr>
                                @endforeach
                            @endif
                        </tbody>
                        </table>
                    </div>
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
            url:"{{route('panel.slider.status')}}",
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
                    url:"{{route('panel.slider.destroy')}}",
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
