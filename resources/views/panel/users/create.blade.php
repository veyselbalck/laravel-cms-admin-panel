@extends('panel.layouts.default')

@section('content')

    <div class="row">
        <div class="col-lg-8 col-md-12">
            <div class="card mb-4">
                <form action="{{ route("users.store") }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">

                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                            <img src="/panel/img/profile.png" class="d-block rounded" height="100" width="100"
                                 id="ProfileHolder"/>

                            <div class="button-wrapper">
                                <div class="mb-3">
                                    <div class="input-group">
                                        <div class="input-group-btn">
                                            <a id="lfmProfile" data-input="thumbProfile" data-preview="ProfileHolder"
                                               class="btn btn-primary">
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
                    <hr class="my-0"/>
                    <div class="card-body">

                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Ad Soyad</label>
                            <input class="form-control" type="text" required id="name" name="name"
                                   value="{{ old("name") }}"/>
                        </div>

                        <div class="form-group mb-3">
                            <label for="email" class="form-label">E-Posta</label>
                            <input class="form-control" type="email" required id="email" name="email"
                                   value="{{ old("email") }}"/>
                        </div>

                        <div class="form-group mb-3">
                            <label for="email" class="form-label">Kullanıcı Grubu</label>
                            <select id="select2Basic" class="select2 form-select form-select-lg" data-allow-clear="true"
                                    name="user_group_id">
                                <option value="">Seçiniz</option>
                                @foreach(\App\Models\Panel\UserGroup::get() as $item)
                                    <option value="{{ $item->id }}"
                                            @if(old("user_group_id")) selected @endif >{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="password" class="form-label">Şifre</label>
                            <input class="form-control" type="password" id="password" name="password"/>
                        </div>

                        <div class="form-group mb-3">
                            <label for="password_confirmation" class="form-label">Şifre Tekrar</label>
                            <input class="form-control" type="password" id="password_confirmation"
                                   name="password_confirmation"/>
                        </div>

                        <div class="form-group mb-3">
                            <label class="switch switch-primary">
                                <input type="checkbox" class="switch-input" name="status" value="1"
                                       @if(old("status", 1)) checked @endif />
                                <span class="switch-toggle-slider"><span class="switch-on"><i
                                                class="bx bx-check"></i></span><span class="switch-off"><i
                                                class="bx bx-x"></i></span></span>
                                <span class="switch-label">Kullanıcı aktif mi?</span>
                            </label>
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
