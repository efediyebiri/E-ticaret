@extends('backend.layout.app')
@section('custom.css')
    <style>
        .ck-content {
            height: 300px !important;
        }
    </style>

@endsection
@section('content')
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Kullanıcı Detay</h4>
                @if ($errors)
                    @foreach ($errors->all() as $error)
                    <div class="alert alert-danger">
                        {{$errors}}
                    </div>
                    @endforeach
                @endif
                @if (session()->get('success'))
                    <div class="alert alert-success">
                        {{session()->get('success')}}
                    </div>
                @endif

                @if (!empty($users->id))
                    @php
                        $routelink = route('panel.users.update',$users->id);
                    @endphp
                    @else
                    @php
                        $routelink = route('panel.users.store');
                    @endphp
                @endif
                <form action="{{$routelink}}" class="forms-sample" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if (!empty($users->id))
                        @method('PUT')
                    @endif

                    <div class="form-group">
                        <div class="input-group col-xs-12">
                            <img src="{{asset($users->image ?? 'img/resimyok.webp')}}" alt="">
                        </div>
                      </div>

                  <div class="form-group">
                    <label for="name">Ad Soyad</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{$users->name ?? ''}}" placeholder="Ad Soyad">
                  </div>

                  <div class="form-group">
                    <label for="name">E-Posta</label>
                    <input type="text" class="form-control" id="email" name="email" value="{{$users->email ?? ''}}" placeholder="E-Posta">
                  </div>

                  <div class="form-group">
                    <label for="password">Şifre</label>
                    <div class="form-group">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Şifre">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="durum">Admin</label>
                    @php
                        $status = $users->status ?? '0';
                    @endphp
                    <select name="status" id="status" class="form-control">
                        <option value="0" {{$status == '0' ? 'selected' : ''}}>Yönetici Yapma</option>
                        <option value="1" {{$status == '1' ? 'selected' : ''}}>Yönetici Yap</option>
                    </select>
                  </div>

                  <button type="submit" class="btn btn-primary mr-2">Kaydet</button>
                  <button class="btn btn-light">İptal et</button>
                </form>
              </div>
            </div>
          </div>
    </div>
@endsection

@section('custom.js')
    <script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/translations/tr.js"></script>

    <script>

        const option = {
            language: 'tr',
                    heading: {
                            options: [
                                { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                                { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                                { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                                { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                                { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                                { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
                                { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
                            ]
                        },
        };
        ClassicEditor
            .create( document.querySelector( '#editor' ) )
            .catch( error => {
                console.error( error );
            } );
    </script>

@endsection
