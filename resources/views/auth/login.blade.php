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
                                    MEDANTALYA
                                </div>
                            </div>
                        </a>
                    </div>

                    {{--                    <h5 class="mb-3 text-center">Craft'a Hoşgeldiniz! 👋</h5>--}}

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
                    <form method="POST" class="mb-3" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">E-Posta/Kullanıcı Adı</label>
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

                        <div class="mb-3 form-password-toggle">
                            <div class="d-flex justify-content-between">
                                <label class="form-label" for="password">Şifre</label>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}">
                                        <small>Şifrenizi mi unuttunuz?</small>
                                    </a>
                                @endif
                            </div>

                            <div class="input-group input-group-merge">
                                <input id="password" type="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       name="password" required
                                       autocomplete="current-password">
                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                            </div>

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember-me" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember-me"> Beni hatırla! </label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary d-grid w-100" type="submit">Giriş Yap</button>
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
