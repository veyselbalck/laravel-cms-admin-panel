@extends('panel.layouts.auth')

@section('content')
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner py-4">

            <div class="card">
                <div class="card-body">
                    <div class="app-brand justify-content-center w-full">
                        <a href="{{route("home")}}" class="app-brand-link gap-2 pt-3 pb-2">
                            <div class="d-flex w-full justify-content-between align-items-center">
                                <div class="app-brand-text demo h3 mb-0 fw-bold">
                                    <img src="/panel/assets/img/branding/logo-full.png" style="width: 200px;">
                                </div>
                            </div>
                        </a>
                    </div>

                    <h5 class="mb-3 text-center">Şifre Yenile</h5>

                    @if ($errors->any())
                        <div class="alert alert-danger alert-styled-left alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
                            <ul class="list-unstyled mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @error('error')
                    <div class="form-group row">
                        <div class="col-md-12 text-center">
                            <span class="text-danger" >{{ $message }}</span>
                        </div>
                    </div>
                    @enderror

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" class="mb-3" action="{{ route('password.email') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">E-Posta</label>
                            <input id="email" type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   name="email"
                                   value="{{ old('email') }}"
                                   required
                                   autocomplete="email"
                                   autofocus>

                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <button class="btn btn-primary d-grid w-100" type="submit">Parola Sıfırlama Bağlantısı Gönder</button>
                            @if (Route::has('login'))
                                <div class="text-center mt-3">
                                    <a href="{{ route('login') }}" class="text-dark">
                                        <span>Giriş Yap</span>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <div class="mt-4 text-center">
                ©
                <script>
                    document.write(new Date().getFullYear());
                </script>
                <a href="{{env('APP_AUTHOR_URL')}}" target="_blank" class="footer-link fw-semibold">{{env('APP_AUTHOR')}}</a>. Tüm hakları saklıdır.
            </div>
        </div>
    </div>
@endsection
