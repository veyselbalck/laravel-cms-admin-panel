@extends('panel.modules.form')

@section("general-form")
    @php
        $column     = !empty($model["settings"]["column"]) ? $model["settings"]["column"] : 4;
    @endphp
    <div class="form-group mb-3">
        <label for="settings.column" class="form-label">Kolon Sayısı</label>
        <select class="select2 form-control" name="settings[column]" id="settings.column">
            <option value="1" @if(old("settings.column", $column) == 1) selected @endif>1 Kolon</option>
            <option value="2" @if(old("settings.column", $column) == 2) selected @endif>2 Kolon</option>
            <option value="3" @if(old("settings.column", $column) == 3) selected @endif>3 Kolon</option>
            <option value="4" @if(old("settings.column", $column) == 4) selected @endif>4 Kolon</option>
            <option value="5" @if(old("settings.column", $column) == 5) selected @endif>5 Kolon</option>
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

    <div class="card mb-4">
        <div class="tab-content px-0 pb-0">
            @foreach(getLanguagesByCodeId() as $lang_code => $lang)
                @php
                    $title          = !empty($model["settings"]["translation"][$lang]["title"]) ? $model["settings"]["translation"][$lang]["title"] : '';
                    $description    = !empty($model["settings"]["translation"][$lang]["description"]) ? $model["settings"]["translation"][$lang]["description"] : '';
                    $button_name    = !empty($model["settings"]["translation"][$lang]["button_name"]) ? $model["settings"]["translation"][$lang]["button_name"] : '';
                    $button_link    = !empty($model["settings"]["translation"][$lang]["button_link"]) ? $model["settings"]["translation"][$lang]["button_link"] : '';
                @endphp
                <div class="tab-pane fade @if($loop->first) show active @endif" id="tab-content-{{$lang_code}}"
                     data-language-id="{{ $lang }}" role="tabpanel">
                    <div class="card-body mb-3">
                        <div class="form-group mb-3">
                            <label class="form-label">Başlık</label>
                            <input type="text" name="settings[translation][{{$lang}}][title]"
                                   value="{{ old('settings.translation.'.$lang.'.title', $title) }}"
                                   class="form-control"/>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Açıklama</label>
                            <input type="text" name="settings[translation][{{$lang}}][description]"
                                   value="{{ old('settings.translation.'.$lang.'.description', $description) }}"
                                   class="form-control"/>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Buton Adı</label>
                            <input type="text" name="settings[translation][{{$lang}}][button_name]"
                                   value="{{ old('settings.translation.'.$lang.'.button_name', $button_name) }}"
                                   class="form-control"/>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Buton Linki</label>
                            <input type="text" name="settings[translation][{{$lang}}][button_link]"
                                   value="{{ old('settings.translation.'.$lang.'.button_link', $button_link) }}"
                                   class="form-control"/>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @php
                $ids_positive = [];
                $ids_negative = [];
                $selectedList = [];
                if(!empty($model->settings["list"])){
                    foreach($model->settings["list"] as $item) {
                        $ids_negative[] = 'id != ' . $item;
                        $ids_positive[] = 'id = ' . $item;
                    }
                }
                $allQuery = \App\Models\Panel\Modules::where("code", "=", "gallery");

                if(count($ids_negative))
                    $allQuery->whereRaw("(" . implode(' AND ', $ids_negative) . ")");

                if(count($ids_positive)) {
                    $selectedList = \App\Models\Panel\Modules::where("code", "=", "gallery");
                    $selectedList->whereRaw("(" . implode(' OR ', $ids_positive) . ")");
                    $selectedList = $selectedList->get();
                }

                $allQuery = $allQuery->get();
            @endphp

            <div class="row">
                <div class="col-md-6 col-12">
                    <h6>SEÇİLEBİLİR GALERİ</h6>
                    <select class="list-all form-control" id="list-all" multiple>
                        @foreach($allQuery as $item)
                            <option value="{{$item->id}}" id="option-{{$item->id}}">{{$item->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 col-12">
                    <h6>SEÇİLENLER</h6>
                    <ul class="list-group table-sortable" id="list-selected" style="min-height: 100px;">
                        @foreach($selectedList as $item)
                            <li class="list-group-item handle cursor-pointer d-flex justify-content-between align-items-center"
                                id="list-{{$item->id}}">
                                <input type="hidden" name="settings[list][]" value="{{$item->id}}">
                                {{$item->name}}
                                <button type="button" class="btn btn-sm p-1 btn-danger remove-selected"
                                        onclick="RemoveSelected($(this))" data-text="{{$item->name}}"
                                        data-id="{{$item->id}}">Vazgeç
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
@endsection

@section('styles')
    <style>
        .list-all {
            height: 400px;
            width: 100%;
            border: 1px solid #cecece;
        }

        .list-all:focus {
            border: 1px solid #cecece
        }

        .list-all option {
            height: 30px;
            display: flex;
            align-items: center;
            width: 100%;
            cursor: pointer;
        }

        .list-all option:hover {
            background-color: #cecece;
        }
    </style>
@endsection

@section('scripts')
    <script>
        $('.list-all').on("change", function () {
            var e = document.getElementById("list-all");
            var value = e.value;
            var text = e.options[e.selectedIndex].text;
            var list = document.getElementById("list-selected");

            var $res = '' +
                '<li class="list-group-item handle cursor-pointer d-flex justify-content-between align-items-center" id="list-' + value + '">' +
                '<input type="hidden" name="settings[list][]" value="' + value + '">' +
                text +
                '<button type="button" class="btn btn-sm p-1 btn-danger remove-selected" onclick="RemoveSelected($(this))" data-text="' + text + '" data-id="' + value + '">Vazgeç</button>' +
                '</li>';

            list.innerHTML += $res;
            document.getElementById("option-" + value).remove();
        });

        var RemoveSelected = function (elem) {
            var value = $(elem).attr("data-id");
            var text = $(elem).attr("data-text");
            $('#list-all').append(`<option value="${value}" id="option-${value}">${text}</option>`);
            $(elem).parent().remove();
        }

        $(function () {
            $("#list-selected").sortable();
        });

    </script>
@endsection
