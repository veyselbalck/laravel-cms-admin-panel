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

                    <h5 class="mb-3 text-center">Email adresinizi doğrulayın</h5>

                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Devam etmeden önce lütfen bir doğrulama bağlantısı için e-postanızı kontrol edin.') }}
                    {{ __('E-postayı almadıysanız') }},

                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <div class="mb-3">
                            <button class="btn btn-primary d-grid w-100" type="submit">başka bir tane iste</button>
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
