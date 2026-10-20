@extends('panel.layouts.default')

@section('content')

    <div class="row">
        <div class="col-lg-8 col-md-12">
            <div class="card mb-4">
                <form action="{{ route("city.store") }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Şehir Adı</label>
                            <input class="form-control" type="text" required id="name" name="name" value="{{ old("name") }}"/>
                        </div>
                    </div>
                    <hr class="my-0" />
                    <div class="card-body">

                        <div class="form-group mb-3">
                            <label for="iso_code_2" class="form-label">Ülke</label>
                            <select class="select2 form-control" name="country_id">
                                @foreach(getCountry() as $country_id => $country_name)
                                    <option value="{{ $country_id }}" @if(old('country_id', config("app.country_id")) == $country_id) selected @endif>
                                        {{ $country_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="code" class="form-label">Code</label>
                            <input class="form-control" type="text" required id="code" name="code" value="{{ old("code") }}"/>
                        </div>

                        <div class="form-group mb-3">
                            <label class="switch switch-primary">
                                <input type="checkbox" class="switch-input" name="status" value="1" @if(old("status", 1)) checked @endif />
                                <span class="switch-toggle-slider"><span class="switch-on"><i class="bx bx-check"></i></span><span class="switch-off"><i class="bx bx-x"></i></span></span>
                                <span class="switch-label">Şehir aktif mi?</span>
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
