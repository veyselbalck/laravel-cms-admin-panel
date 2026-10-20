@extends('panel.layouts.default')

@section('content')
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">Hesap Ayarları /</span> Profil
    </h4>

    <div class="row">
        <div class="col-lg-8 col-md-12">
            <div class="card mb-4">
                <h5 class="card-header">Profil Detayları</h5>
                <form action="{{ route("profile.update", auth()->user()->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method("PUT")
                    <div class="card-body">

                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                            <img src="{{ auth()->user()->thumb }}" class="d-block rounded" height="100" width="100" id="ProfileHolder" />

                            <div class="button-wrapper">
                                <div class="mb-3">
                                    <div class="input-group">
                                        <div class="input-group-btn">
                                            <a id="lfmProfile" data-input="thumbProfile" data-preview="ProfileHolder" class="btn btn-primary">
                                                <i class="fa fa-picture-o"></i> Görsel Seç
                                            </a>
                                        </div>
                                        <input id="thumbProfile" class="form-control" type="text" name="image" readonly>
                                    </div>
                                </div>

                                <p class="mb-0">JPG, JPEG, PNG formatında ve maks. 3MB boyutunda olması gereklidir.</p>
                            </div>
                        </div>
                    </div>
                    <hr class="my-0" />
                    <div class="card-body">

                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Ad Soyad</label>
                            <input class="form-control" type="text" required id="name" name="name" value="{{auth()->user()->name}}"/>
                        </div>

                        <div class="form-group mb-3">
                            <label for="email" class="form-label">E-Posta</label>
                            <input class="form-control" type="email" required id="email" name="email" value="{{auth()->user()->email}}"/>
                        </div>

                        <div class="form-group mb-3">
                            <label for="password" class="form-label">Şifre</label>
                            <input class="form-control" type="password" id="password" name="password"/>
                        </div>

                        <div class="form-group mb-3">
                            <label for="password_confirmation" class="form-label">Şifre Tekrar</label>
                            <input class="form-control" type="password" id="password_confirmation" name="password_confirmation"/>
                        </div>

                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary me-2">Kaydet</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push("styles") @endpush

@push("scripts")
    <script>
        $('#lfmProfile').filemanager('image');
    </script>
@endpush
