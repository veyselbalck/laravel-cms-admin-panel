@extends('panel.layouts.default')

@section('content')

    <div class="row">
        <div class="col-lg-8 col-md-12">
            <div class="card mb-4">
                <form action="{{ route("testimonial.update", $model->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method("PUT")
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Ad Soyad</label>
                            <input class="form-control" type="text" required id="name" name="name" value="{{ old("name", $model->name) }}"/>
                        </div>

{{--                        <div class="form-group mb-3">--}}
{{--                            <label for="title" class="form-label">Ünvan</label>--}}
{{--                            <input class="form-control" type="text" required id="title" name="title" value="{{ old("title", $model->title) }}"/>--}}
{{--                        </div>--}}
                    </div>
                    <hr class="my-0" />
                    <div class="card-body">
{{--                        <div class="form-group mb-3">--}}
{{--                            <label for="file" class="form-label">Profil Resmi</label>--}}
{{--                            <input class="form-control" type="file" id="file" name="image" value="{{ old("image") }}"/>--}}

{{--                            <input type="hidden" name="old_image" value="{{$model->profile}}">--}}
{{--                            @if($model->profile)--}}
{{--                                <img src="{{ asset($model->profile) }}" style="height: 5rem; margin-top:10px" class="d-inline-block">--}}
{{--                            @endif--}}
{{--                        </div>--}}



                        <ul class="nav nav-tabs tabs-line pt-2" role="tablist">
                            @foreach(getModelLanguages() as $lang)
                                <li class="nav-item">
                                    <button type="button" class="nav-link @if($loop->first) active @endif" role="tab" data-bs-toggle="tab"
                                            data-bs-target="#tab-content-{{$lang->code}}"
                                            aria-controls="tab-content-{{$lang->code}}"
                                            aria-selected="true">
                                        {{$lang->name}}
                                    </button>
                                </li>
                            @endforeach
                        </ul>

                        <div class="tab-content px-0 pb-0">
                            @foreach(getLanguagesByCodeId() as $lang_code => $lang)
                                @php
                                    $message = !empty($model["datas"]["translation"][$lang]["message"]) ? $model["datas"]["translation"][$lang]["message"] : '';
                                @endphp
                                <div class="tab-pane fade @if($loop->first) show active @endif" id="tab-content-{{$lang_code}}" data-language-id="{{ $lang }}" role="tabpanel">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Mesaj</label>
                                        <textarea class="form-control" type="text" name="datas[translation][{{$lang}}][message]">{{ old('datas.translation.'.$lang.'.message', $message) }}</textarea>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="form-group mb-3">
                            <label class="switch switch-primary">
                                <input type="checkbox" class="switch-input" name="status" value="1" @if(old("status", $model->status) == 1) checked @endif />
                                <span class="switch-toggle-slider"><span class="switch-on"><i class="bx bx-check"></i></span><span class="switch-off"><i class="bx bx-x"></i></span></span>
                                <span class="switch-label">Kullanıcı görüşü aktif edilsin mi?</span>
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
