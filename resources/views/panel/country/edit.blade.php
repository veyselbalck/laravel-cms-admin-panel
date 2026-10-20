@extends('panel.layouts.default')

@section('content')

    <div class="row">
        <div class="col-lg-8 col-md-12">
            <div class="card mb-4">
                <form action="{{ route("country.update", $model->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method("PUT")
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Ülke Adı</label>
                            <input class="form-control" type="text" required id="name" name="name" value="{{ old("name", $model->name) }}"/>
                        </div>
                    </div>
                    <hr class="my-0" />
                    <div class="card-body">

                        <div class="form-group mb-3">
                            <label for="iso_code_2" class="form-label">ISO Kodu (2)</label>
                            <input class="form-control" type="text" required id="iso_code_2" name="iso_code_2" value="{{ old("iso_code_2", $model->iso_code_2) }}"/>
                        </div>

                        <div class="form-group mb-3">
                            <label for="iso_code_3" class="form-label">ISO Kodu (3)</label>
                            <input class="form-control" type="text" required id="iso_code_3" name="iso_code_3" value="{{ old("iso_code_3", $model->iso_code_3) }}"/>
                        </div>

                        <div class="form-group mb-3">
                            <label for="address_format" class="form-label"
                                   data-bs-toggle="tooltip"
                                   data-bs-offset="0,4"
                                   data-bs-placement="right"
                                   data-bs-html="true"
                                   title="Ad = {firstname}<br />Soyad = {lastname}<br />Şirket Adı = {company}<br />Adres 1 = {address_1}<br />Adres 2 = {address_2}<br />Posta Kodu = {postcode}<br />Şehir = {city}<br />Şehir Kodu = {city_code}<br />Ülke = {country}">
                            Adres Formatı <i class="bx bx-info-circle"></i> </label>
                            <textarea class="form-control" type="text" id="address_format" name="address_format">{{ old("address_format", $model->address_format) }}</textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label class="switch switch-primary">
                                <input type="checkbox" class="switch-input" name="postcode_required" value="1" @if(old("postcode_required", $model->postcode_required)) checked @endif />
                                <span class="switch-toggle-slider"><span class="switch-on"><i class="bx bx-check"></i></span><span class="switch-off"><i class="bx bx-x"></i></span></span>
                                <span class="switch-label">Posta Kodu aktif mi?</span>
                            </label>
                        </div>

                        <div class="form-group mb-3">
                            <label class="switch switch-primary">
                                <input type="checkbox" class="switch-input" name="status" value="1" @if(old("status", $model->status)) checked @endif />
                                <span class="switch-toggle-slider"><span class="switch-on"><i class="bx bx-check"></i></span><span class="switch-off"><i class="bx bx-x"></i></span></span>
                                <span class="switch-label">Ülke aktif mi?</span>
                            </label>
                        </div>

                        <div class="my-3">
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
