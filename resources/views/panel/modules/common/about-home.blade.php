@extends('panel.modules.form')

@section("general-form")
    @php
        $list_type = !empty($model["settings"]["list_type"]) ? $model["settings"]["list_type"] : 1;
    @endphp
    <div class="form-group mb-3">
        <label for="settings.parallax" class="form-label">Görüntüleme Türü</label>
        <select class="select2 form-control" name="settings[list_type]" id="settings.list_type">
            <option value="1" @if(old("settings.list_type", $list_type) == 1) selected @endif>Anasayfa Konsept</option>
            <option value="2" @if(old("settings.list_type", $list_type) == 2) selected @endif>İçerik Konsept</option>
        </select>
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



    @php
        $image = !empty($model["settings"]["image"]) ? $model["settings"]["image"] : "";
        $image2 = !empty($model["settings"]["image2"]) ? $model["settings"]["image2"] : "";
        $video = !empty($model["settings"]["video"]) ? $model["settings"]["video"] : "";
    @endphp


    <div class="card mb-4">
        <div class="tab-content px-0 pb-0">
            @foreach(getLanguagesByCodeId() as $lang_code => $lang)
                @php
                    $title      = !empty($model["settings"]["translation"][$lang]["title"]) ? $model["settings"]["translation"][$lang]["title"] : '';
                    $subtitle   = !empty($model["settings"]["translation"][$lang]["subtitle"]) ? $model["settings"]["translation"][$lang]["subtitle"] : '';
                    $description= !empty($model["settings"]["translation"][$lang]["description"]) ? $model["settings"]["translation"][$lang]["description"] : '';
                    $url        = !empty($model["settings"]["translation"][$lang]["url"]) ? $model["settings"]["translation"][$lang]["url"] : '';
                @endphp

                <div class="tab-pane fade @if($loop->first) show active @endif" id="tab-content-{{$lang_code}}" data-language-id="{{ $lang }}" role="tabpanel">
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="settings.title" class="form-label">Başlık</label>
                            <input type="text" class="form-control" name="settings[translation][{{$lang}}][title]" value="{{old("settings.translation.".$lang.".title", $title)}}">
                        </div>

                        <div class="form-group mb-3">
                            <label for="settings.subtitle" class="form-label">Alt Başlık</label>
                            <input type="text" class="form-control" name="settings[translation][{{$lang}}][subtitle]" value="{{old("settings.translation.".$lang.".subtitle", $subtitle)}}">
                        </div>

                        <div class="form-group mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="form-label">Açıklama</label>
                            </div>
                            <textarea name="settings[translation][{{$lang}}][description]" id="editorck" data-height="300" class="form-control textareack editor-ck">{{old("settings.translation.".$lang.".description", $description)}}</textarea>
                        </div>

                        <div class="form-group mb-3">
                            <label for="settings.url" class="form-label">URL</label>
                            <input type="text" class="form-control" name="settings[translation][{{$lang}}][url]" value="{{old("settings.translation.".$lang.".url", $url)}}">
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="card-body">
                <div class="col-12">
                    <div class="form-group mb-3">
                        <label class="form-label">Görsel</label>
                        <div class="input-group">
                            <input id="thumbnailImg" class="form-control" type="text" name="settings[image]" value="{{$image}}" readonly required>
                            <div class="input-group-btn">
                                <a id="lfmImage" data-input="thumbnailImg" data-preview="holder" class="btn btn-primary text-white"><i class="fa fa-picture-o"></i> Görsel Seç</a>
                            </div>
                        </div>
                        <div id="holder" class="mt-3">
                            @if($image)
                            <img src="{{ $image }}" style="max-width: 300px;  border-radius: 5px;">
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('modals')
@endsection

@section('styles') @endsection
@section('scripts')
    <script>
        $('#lfmImage').filemanager('image');
        $('#lfmImage2').filemanager('image');
        $('#lfmVideo').filemanager('image');
    </script>
@endsection
