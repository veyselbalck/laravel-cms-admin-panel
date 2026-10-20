@extends('panel.layouts.default')

@section('content')
    <div class="row">
        <div class="col-lg-8 col-md-12">
            <div class="card mb-4">
                <form action="{{ route("seo_redirect.store") }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="name" class="form-label text-danger">Başlık *</label>
                            <input type="text" class="form-control" required name="title" value="{{old('title')}}">
                        </div>
                    </div>
                    <hr class="my-0" />
                    <div class="card-body">

                        <div class="form-group mb-3">
                            <label for="address" class="form-label">Geçerli Adres</label>
                            <input type="text" class="form-control" name="address" value="{{old('address')}}">
                        </div>

                        <div class="form-group mb-3">
                            <label for="redirect" class="form-label">Yönlendirilen Adres</label>
                            <input type="text" class="form-control" name="redirect" value="{{old('redirect')}}">
                        </div>

                        <div class="form-group mb-3">
                            <label for="http_status" class="form-label">HTTP Status</label>
                            <input type="text" class="form-control" name="http_status" value="{{old('http_status', 301)}}">
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
@endpush
