@extends('panel.modules.form')

@section("general-form")
    @php
        $image = !empty($model["settings"]["image"]) ? $model["settings"]["image"] : '';
        $image_src = $image ? $image : "/panel/img/full-with-img.png";
    @endphp

    <div class="form-group mb-3">
        <label class="form-label text-danger">Görsel *</label>
        <a data-input="popupImage" data-preview="PopupHolder" class="lfm-image">
            <img src="{{ old("image", $image_src) }}"
                 class="d-block rounded mb-3 cursor-pointer" style="max-width: 100%; max-height: 350px;" id="PopupHolder"/>
        </a>
        <input id="popupImage" class="form-control mb-1" onchange="lfmInput($(this))" type="hidden"
               name="settings[image]" value="{{ old("settings.image", $image) }}" readonly data-value="" required>
    </div>
@endsection

@section("module-form")
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

    <div class="card mb-4">
        <div class="tab-content px-0 pb-0">
            @foreach(getLanguagesByCodeId() as $lang_code => $lang)
                @php
                    $title          = !empty($model["settings"][$lang]["title"]) ? $model["settings"][$lang]["title"] : '';
                    $description    = !empty($model["settings"][$lang]["description"]) ? $model["settings"][$lang]["description"] : '';
                    $button_name    = !empty($model["settings"][$lang]["button_name"]) ? $model["settings"][$lang]["button_name"] : '';
                    $button_link    = !empty($model["settings"][$lang]["button_link"]) ? $model["settings"][$lang]["button_link"] : '';
                @endphp
                <div class="tab-pane fade @if($loop->first) show active @endif" id="tab-content-{{$lang_code}}" data-language-id="{{ $lang }}" role="tabpanel">
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label class="form-label">Başlık</label>
                            <input type="text" name="settings[{{$lang}}][title]" value="{{ old('settings.'.$lang.'.title', $title) }}" class="form-control" />
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Açıklama</label>
                            <input type="text" name="settings[{{$lang}}][description]" value="{{ old('settings.'.$lang.'.description', $description) }}" class="form-control" />
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Buton Adı</label>
                            <input type="text" name="settings[{{$lang}}][button_name]" value="{{ old('settings.'.$lang.'.button_name', $button_name) }}" class="form-control" />
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Buton Linki</label>
                            <input type="text" name="settings[{{$lang}}][button_link]" value="{{ old('settings.'.$lang.'.button_link', $button_link) }}" class="form-control" />
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@section('modals')
@endsection

@section('styles') @endsection
@section('scripts')
@endsection
