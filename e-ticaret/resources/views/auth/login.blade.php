@extends('frontend.layout.layout1')
<style>
    body, html {
        height: 100%;
        margin: 0;
        padding: 0;
    }
    .full-screen {
        height: 100%;
        width: 100%;
        background-image: url('https://images.squarespace-cdn.com/content/v1/5ec321c2af33de48734cc929/1589847937789-NV3F3ZYYY4ONB3FGZQE8/20140301_Trade-151_0124-copy.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }
</style>
@section('content')
<div class="full-screen">
    <div class="container ortala">
        <div class="d-flex justify-content-center align-items-center" style="min-height: 100vh;">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Giriş Yap') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login_complate') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('E-Posta Adresi') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Şifre') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Beni Hatırla') }}
                                        </label>
                                    </div>

                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary" >
                                        {{ __('GİRİŞ') }}
                                    </button>
                                    @if (Route::has('register'))
                                    <a class="btn btn-link" href="{{ route('register') }}">
                                        {{ __('KAYIT OL') }}
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                        <form method="POST" action="{{route('password.request')}}">
                            @csrf
                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <a class="btn-link" href="{{route('password.request')}}">Şifremi Unuttum</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
