@extends('panel.layouts.default')

@section('content')

    <form action="{{ route("languages.update", $model->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method("PUT")
    <div class="w-full text-end" style="margin-top: -45px;">
        <button type="submit" class="btn btn-warning"><i class="bx bxs-save"></i> Kaydet</button>
    </div>
    <div class="row mt-2">
        <div class="col-lg-12 col-md-12">
            <div class="card mb-4">
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="name" class="form-label text-danger">Dil Adı *</label>
                            <input type="text" class="form-control" required name="name" value="{{old('name', $model->name)}}">
                        </div>
                    </div>

                    <hr class="my-0" />

                    <div class="card-body">

                        <div class="form-group mb-3">
                            <label for="address" class="form-label text-danger">Dil Kodu *</label>
                            <input type="text" class="form-control" name="code" value="{{old('code', $model->code)}}">
                        </div>

                        <div class="form-group mb-3">
                            <label for="sort_order" class="form-label">Sıra No</label>
                            <input type="text" class="form-control" name="sort_order" value="{{old('sort_order', $model->sort_order)}}">
                        </div>

                        <div class="form-group mb-3">
                            <label class="switch switch-primary">
                                <input type="checkbox" class="switch-input" name="status" value="1" @if(old("status", $model->status)) checked @endif />
                                <span class="switch-toggle-slider"><span class="switch-on"><i class="bx bx-check"></i></span><span class="switch-off"><i class="bx bx-x"></i></span></span>
                                <span class="switch-label">Dil aktif mi?</span>
                            </label>
                        </div>
                    </div>
            </div>

            @include("panel.languages.translation")

        </div>
    </div>
    </form>
@endsection

@push("styles") @endpush

@push("scripts")
    <script>
        $('#lfmProfile').filemanager('image');
    </script>
@endpush
