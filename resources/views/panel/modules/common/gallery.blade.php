@extends('panel.modules.form')

@section("general-form")
    @php
        $parallax   = !empty($model["settings"]["parallax"]) ? $model["settings"]["parallax"] : 0;
        $column     = !empty($model["settings"]["column"]) ? $model["settings"]["column"] : 1;
        $type       = !empty($model["settings"]["type"]) ? $model["settings"]["type"] : 'photo';
        $image      = !empty($model["settings"]["image"]) ? $model["settings"]["image"] : '';
        $image_src  = $image ? $image : "/panel/img/placeholder.png";
    @endphp

    <div class="form-group mb-3">
        <label for="settings.column" class="form-label">Kolon Sayısı</label>
        <select class="select2 form-control" name="settings[column]" id="settings.column">
            <option value="1" @if(old("settings.column", $column) == 1) selected @endif>1 Kolon</option>
            <option value="2" @if(old("settings.column", $column) == 2) selected @endif>2 Kolon</option>
            <option value="3" @if(old("settings.column", $column) == 3) selected @endif>3 Kolon</option>
            <option value="3" @if(old("settings.column", $column) == 4) selected @endif>4 Kolon</option>
            {{--            <option value="3" @if(old("settings.column", $column) == 5) selected @endif>5 Kolon</option>--}}
        </select>
    </div>

    <div class="form-group mb-3">
        <label for="settings.column" class="form-label">Galeri Türü</label>
        <select class="select2 form-control" name="settings[type]" id="settings.type">
            <option value="photo" @if(old("settings.type", $type) == 'photo') selected @endif>Fotoğraf</option>
            <option value="video" @if(old("settings.type", $type) == 'video') selected @endif>Video</option>
        </select>
    </div>

    <div class="form-group mb-3">
        <label class="form-label text-danger">Kapak Görseli *</label>
        <a data-input="CoverImage" data-preview="CoverHolder" class="lfm-image">
            <img src="{{ old("image", $image_src) }}"
                 class="d-block rounded mb-3 cursor-pointer" style="max-width: 100%; max-height: 350px;" id="CoverHolder"/>
        </a>
        <input id="CoverImage" class="form-control mb-1" onchange="lfmInput($(this))" type="hidden"
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
                    $title          = !empty($model["settings"]["translation"][$lang]["title"]) ? $model["settings"]["translation"][$lang]["title"] : '';
                    $description    = !empty($model["settings"]["translation"][$lang]["description"]) ? $model["settings"]["translation"][$lang]["description"] : '';
                    $slug           = !empty($model["settings"]["translation"][$lang]["slug"]) ? $model["settings"]["translation"][$lang]["slug"] : '';
                    $button_name    = !empty($model["settings"]["translation"][$lang]["button_name"]) ? $model["settings"]["translation"][$lang]["button_name"] : '';
                    $button_link    = !empty($model["settings"]["translation"][$lang]["button_link"]) ? $model["settings"]["translation"][$lang]["button_link"] : '';
                @endphp
                <div class="media-tab-pane tab-pane fade @if($loop->first) show active @endif" id="tab-content-{{$lang_code}}" data-language-id="{{ $lang }}" role="tabpanel">
                    <div class="card-body mb-3">
                        <div class="form-group mb-3">
                            <label class="form-label">Başlık</label>
                            <input type="text" name="settings[translation][{{$lang}}][title]"
                                   id="settings_translation_{{$lang}}_title"
                                   value="{{ old('settings.translation.'.$lang.'.title', $title) }}" class="form-control" />
                        </div>

                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Slug/Link</label>
                            <div class="input-group">
                                <input class="form-control" type="text" name="settings[translation][{{$lang}}][slug]"
                                       id="settings_translation_{{$lang}}_slug"
                                       value="{{ old("descriptions.".$lang.".slug") }}"/>
                                <button type="button" class="btn btn-dark"
                                        onclick="$('#settings_translation_{{$lang}}_slug').val(slugify($('#settings_translation_{{$lang}}_title').val()))">Oluştur</button>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Açıklama</label>
                            <input type="text" name="settings[translation][{{$lang}}][description]" value="{{ old('settings.translation.'.$lang.'.description', $description) }}" class="form-control" />
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Buton Adı</label>
                            <input type="text" name="settings[translation][{{$lang}}][button_name]" value="{{ old('settings.translation.'.$lang.'.button_name', $button_name) }}" class="form-control" />
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Buton Linki</label>
                            <input type="text" name="settings[translation][{{$lang}}][button_link]" value="{{ old('settings.translation.'.$lang.'.button_link', $button_link) }}" class="form-control" />
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="text-end mt-3 mb-md-n3">
                            <button type="button" class="btn btn-dark"  onclick="modal_module_add()"><i class="bx bx-plus"></i> Ekle</button>
                        </div>
                    </div>

                    <h5 class="card-header pt-0">Videolar/Görseller</h5>

                    <div class="table-responsive text-nowrap">
                        <table class="table table-bordered table-hover table-sortable" data-key="items">
                            <thead class="table-dark">
                            <tr>
                                <th class="text-center" width="1">Sırala</th>
                                <th data-key="image" class="text-center" width="150">Medya</th>
                                <th data-key="title">Başlık</th>
                                <th class="text-center" width="1">Kopyala</th>
                                <th class="text-center" width="1">Düzenle</th>
                                <th class="text-center" width="1">Sil</th>
                            </tr>
                            </thead>
                            <tbody class="table-border-bottom-0" data-tbody="items">
                            @if(!empty($items[$lang]))
                                @foreach($items[$lang] as $key => $item)
                                    <tr data-id="{{$key}}">
                                        <td class="dragula-handle ui-draggable-handle"><i class="bx bx-dots-vertical"></i> </td>
                                        <td>
                                            <?php
                                                $ex = explode(".", $item["image"]);
                                                $file_type = !empty($item["file_type"]) ? $item["file_type"] : "";
                                                ?>
                                            @if(($ex[count($ex) - 1] == "jpg" || $ex[count($ex) - 1] == "jpeg" || $ex[count($ex) - 1] == "png" || $ex[count($ex) - 1] == "gif" || $ex[count($ex) - 1] == "svg") && ($file_type == "file" || $file_type == ""))
                                                <img src="{{asset($item["image"])}}" alt="" width="150" class="img-preview rounded">
                                            @else
                                                @if($file_type != "" && $file_type != "file")
                                                    <span class="df-icon {{$file_type}}">{{$file_type}}</span>
                                                @else
                                                    <span class="df-icon {{$ex[count($ex) - 1]}}">{{$ex[count($ex) - 1]}}</span>
                                                @endif
                                            @endif
                                        </td>
                                        <td>{{$item["title"]}}</td>

                                        <td class="text-center">
                                            <a href="javascript:;" class="btn btn-block text-primary" data-Cover="tooltip" title="Kopyala" onclick="modal_module_duplicate(this)">
                                                <i class="bx bxs-file-plus"></i>
                                            </a>
                                        </td>

                                        <td class="text-center">
                                            <input type="hidden" name="settings[items][{{$lang}}][{{$key}}][title]" value="{{$item["title"]}}" data-edit-name="title">
                                            <input type="hidden" name="settings[items][{{$lang}}][{{$key}}][description]" value="{{$item["title"]}}" data-edit-name="description">
                                            <input type="hidden" name="settings[items][{{$lang}}][{{$key}}][image]" value="{{$item["image"] ? asset($item["image"]) : ""}}" data-edit-name="image">
                                            <input type="hidden" name="settings[items][{{$lang}}][{{$key}}][sort_order]" value="{{ !empty($item["sort_order"]) ? $item["sort_order"] : 999 }}" data-edit-name="sort_order">
                                            <input type="hidden" name="settings[items][{{$lang}}][{{$key}}][file_type]" value="{{ !empty($item["file_type"]) ? $item["file_type"] : 'file' }}" data-edit-name="file_type">
                                            <input type="hidden" name="settings[items][{{$lang}}][{{$key}}][video_id]" value="{{ !empty($item["video_id"]) ? $item["video_id"] : '' }}" data-edit-name="video_id">
                                            <a href="javascript:;" class="btn btn-block text-primary" data-Cover="tooltip" title="Düzenle" onclick="modal_module_edit(this)"><i class="bx bx-pencil"></i></a>
                                        </td>

                                        <td class="text-center">
                                            <a href="javascript:;" class="btn btn-block text-danger" data-Cover="tooltip" title="Sil" onclick="$(this).closest('tr').remove()">
                                                <i class="bx bx-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr id="no-record">
                                    <td colspan="20" class="text-center">Kayıt Bulunamadı.</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@section('modals')
    <div class="modal fade" id="modal_module" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-simple">
            <div class="modal-content p-3 p-md-5">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="text-center mb-4">
                        <h3 class="address-title modal-title-add">Yeni İçerik Ekle</h3>
                        <h3 class="address-title modal-title-update d-none">İçerik Güncelle</h3>
                    </div>
                    <form class="row g-3" id="modal_module_id" onsubmit="return modal_module_submit(event)">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label class="form-label">Başlık</label>
                                    <input type="text" name="title" data-value="" data-type="text" class="form-control" />
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label class="form-label">Açıklama</label>
                                    <input type="text" name="description" data-value="" data-type="text" class="form-control" />
                                </div>
                            </div>

                            <div class="col-md-12 col-12">
                                <div class="form-group mb-3">
                                    <label class="form-label">Sıra Numarası</label>
                                    <input type="text" name="sort_order" data-value="999" data-type="text" class="form-control" />
                                </div>
                            </div>

                            <div class="col-md-12 col-12">
                                <div class="form-group mb-3">
                                    <label class="form-label">Video Türü</label>
                                    <select class="form-control" name="file_type" id="file_type">
                                        <option value="file" id="type-file">Dosya</option>
                                        <option value="youtube" id="type-file-youtube">You Tube</option>
                                        <option value="vimeo" id="type-file-vimeo">Vimeo</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12" id="file-type-file">
                                <div class="form-group mb-3">
                                    <label class="form-label">Video/Görsel</label>
                                    <div class="input-group">
                                        <input id="thumbnailFile" class="form-control" type="text" name="image" readonly required data-value="" data-type="image">
                                        <div class="input-group-btn">
                                            <a id="lfmFile" data-input="thumbnailFile" data-preview="holder2" class="btn btn-primary text-white">
                                                <i class="fa fa-picture-o"></i> Video/Görsel Seç
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 col-12 d-none" id="file-type-youtube-vimeo">
                                <div class="form-group mb-3">
                                    <label class="form-label" id="label-file-type">You Tube ID</label>
                                    <input type="text" name="video_id" id="video_id" data-value="" data-type="text" class="form-control" />
                                </div>
                            </div>
                        </div>

                        <div class="col-12 text-center mt-4">
                            <button type="submit" class="btn btn-primary">Kaydet</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles') @endsection
@section('scripts')
    <script>
        $("#file_type").on("change", function () {
            var e = document.getElementById("file_type");
            var value = e.value;

            if(value === "file" || value === "") {
                document.getElementById("file-type-file").classList.remove("d-none");
                document.getElementById("file-type-youtube-vimeo").classList.add("d-none");
                document.getElementById("thumbnailFile").required = true;
                document.getElementById("video_id").required = false;
                document.getElementById("type-file").selected = true;
            } else {
                if(value === "youtube")
                    document.getElementById("label-file-type").innerText = "You Tube ID";
                else
                    document.getElementById("label-file-type").innerText = "Vimeo ID";

                document.getElementById("file-type-file").classList.add("d-none");
                document.getElementById("file-type-youtube-vimeo").classList.remove("d-none");
                document.getElementById("thumbnailFile").required = false;
                document.getElementById("video_id").required = true;
            }
        });
    </script>
    @php($input_type ='hidden')
    <script>
        var edit_id = -1;
        var input_elements = 'input, select, textarea';
        function modal_module_add() {

            edit_id = -1;
            $('[data-placeholder]').each(function () {
                $(this).attr('src', '{{ asset('panel/img/full-with-img.png') }}')
            })

            $('#modal_module .modal-body').find(input_elements).each(function () {
                var type = $(this)[0].tagName;
                var value = $(this).data('value') ? $(this).data('value') : '';
                $(this).val(value);
                if(type.toLowerCase() == 'select'){
                    $(this).trigger('change');
                }
            });

            $('#modal_module .modal-body .button-image-clear').addClass('d-none');

            $('.modal-title-add').removeClass('d-none');
            $('.modal-title-update').addClass('d-none');

            $('#modal_module [type="submit"]').text('Ekle');

            $('#modal_module').modal('show');
        }

        function modal_module_duplicate(element) {
            var tr = $(element).closest('tr').clone();

            var id = Panel.uid();
            tr = $(tr)[0].outerHTML.replace(new RegExp($(element).closest('tr').data('id'), 'g'), id);

            $('.media-tab-pane.active tbody').append(tr);
        }

        function modal_module_edit(element) {
            $('#modal_module [type="submit"]').text('Güncelle');

            var tr = $(element).closest('tr');

            edit_id = tr.data('id');

            $('#modal_module .modal-body .button-image-clear').addClass('d-none');
            $('[data-placeholder]').each(function () {
                $(this).attr('src', '{{ asset('panel/img/full-with-img.png') }}')
            })

            $.each(tr.find(input_elements), function () {
                var key = $(this).data('edit-name');
                var val = $(this).val();

                if(key === "file_type") {
                    if(val === "youtube" || val === "vimeo") {
                        document.getElementById("type-file-" + val).selected = true;
                        document.getElementById("file-type-file").classList.add("d-none");
                        document.getElementById("file-type-youtube-vimeo").classList.remove("d-none");
                        document.getElementById("thumbnailFile").required = false;
                        document.getElementById("video_id").required = true;
                    } else
                    {
                        document.getElementById("file-type-file").classList.remove("d-none");
                        document.getElementById("file-type-youtube-vimeo").classList.add("d-none");
                        document.getElementById("type-file").selected = true;
                        document.getElementById("thumbnailFile").required = true;
                        document.getElementById("video_id").required = false;
                    }
                }


                var target = $('#modal_module .modal-body [name="'+key+'"]');
                var type = $(target).data('type');
                switch (type){
                    case 'text':
                        $(target).val(val);
                        $(target).trigger('change');
                        break;
                    case 'textarea':
                        $(target).text(val);
                        break;
                    case 'select':
                        $(target).val(val);
                        $(target).trigger('change');
                        break;
                    case 'status':
                        $(target).val(val);
                        $(target).trigger('change');
                        break;
                    case 'image':
                        $(target).val(val);
                        if (val){
                            $('[data-placeholder]').each(function () {
                                $(this).attr('src', val)
                            })
                            $(target).closest('.input-group').find('img').attr('src', val);
                            $(target).closest('.input-group').find('.button-image-clear').removeClass('d-none');
                        }
                        break;
                }
            });

            $('.modal-title-add').addClass('d-none');
            $('.modal-title-update').removeClass('d-none');
            $('#modal_module').modal('show');
        }

        function modal_module_submit(e) {
            e.preventDefault();

            var item = {};

            $(e.target).find(input_elements).each(function () {
                item[$(this).attr('name')] = {
                    value:$(this).val(),
                    default:$(this).attr('data-value'),
                    type:$(this).attr('data-type'),
                }
            });

            var id = edit_id == -1 ? uid() : edit_id;

            var template = modal_module_template(id, item);

            if(template) {
                if (edit_id != -1) {
                    $('.media-tab-pane.active tbody').find('[data-id="' + id + '"]').html(template);
                } else {
                    $('.media-tab-pane.active tbody').append('<tr data-id="' + id + '">' + template + '</tr>');
                }
            }

            $('#modal_module').modal('hide');
            // kayıt bulunamadı satırını silelim.
            noRecordTextDelete();

            return false;
        }

        let video_id = "";
        let file_type = "";

        function modal_module_template(id, item) {
            var content = '';
            var language_id = $('.media-tab-pane.active').data('language-id');

            var inputs = '';
            var flag = '', split_files = '';
            $.each(item, function (name, data) {
                var value = data.value ? data.value : data.default ? data.default : '';
                switch (data.type){
                    case 'textarea':
                        inputs += '<textarea name="settings[items]['+language_id+']['+id+']['+name+']" data-edit-name="'+name+'" class="d-none">'+value+'</textarea>';

                        break;
                    case 'image':
                        var img_value = data.value;
                        split_files = img_value.split(",")
                        if(split_files.length > 1) {
                            if(edit_id === -1) {
                                flag = 1;
                            } else {
                                data.value = split_files[0];
                                value = data.value;
                            }
                        }
                        inputs += '<input type="{{ $input_type }}" name="settings[items]['+language_id+']['+id+']['+name+']" value="'+value+'" data-edit-name="'+name+'">';

                        break;
                    default:
                        if(name === "video_id") video_id = value;
                        if(name === "file_type") file_type = value;
                        inputs += '<input type="{{ $input_type }}" name="settings[items]['+language_id+']['+id+']['+name+']" value="'+value+'" data-edit-name="'+name+'">';
                        break;
                }
            });

            if(flag === 1) {
                modal_module_template_multiple(item, split_files)
                return false;
            }
            content += '<td class="dragula-handle ui-draggable-handle"><i class="bx bx-dots-vertical"></i> </td>';

            $('.media-tab-pane.active table th[data-key]').each(function (index, th) {
                if(item[$(th).data('key')]){
                    var data = item[$(th).data('key')];
                    var value = data.value ? data.value : data.default ? data.default : '';
                    var center = data.type === "image" ? 'class="text-center"' : '';
                    content += '<td '+center+'>';

                    switch (data.type){
                        case 'image':
                            if(file_type !== "file") {
                                var res = '<span class="df-icon ' + file_type + '">' + file_type + "</span>";
                            } else {
                                var ex = [];
                                var value_full = value;
                                if(value) {
                                    ex = value.toString().split(".");
                                    value = ex[ex.length - 1];
                                }
                                var res = '<span class="df-icon ' + value + '">' + value + "</span>";
                                if(value === "jpg" || value === "jpeg" || value === "png" || value === "gif" || value === "svg")
                                    res = '<img src="'+value_full+'" width="150" class="img-fluid" alt="">';
                                // var image = value ? '/img/icons/' + value + ".png" : '';
                            }
                            value = res;
                            break;
                        case 'select':
                            if(value){
                                value = $('option[value="'+value+'"]').html();
                            }else{
                                value = '-';
                            }
                            break;
                        case 'status':
                            if(value == 1){
                                value = '<span class="badge bg-success">{{ "Aktif" }}</span>';
                            }else{
                                value = '<span class="badge bg-danger">{{ "Pasif" }}</span>';
                            }
                            break;
                    }

                    content += value;
                    content += '</td>';
                }
            });

            content += '<td class="text-center">';
            content += '<a href="javascript:;" class="btn btn-block text-primary" data-Cover="tooltip" title="Kopyala" onclick="modal_module_duplicate(this)"><i class="bx bxs-file-plus"></i></a>';
            content += '</td>';


            content += '<td class="text-center">';
            content += inputs;
            content += '<a href="javascript:;" class="btn btn-block text-primary" data-Cover="tooltip" title="Düzenle" onclick="modal_module_edit(this)"><i class="bx bx-pencil"></i></a>';
            content += '</td>';


            content += '<td class="text-center">';
            content += '<a href="javascript:;" class="btn btn-block text-danger" data-Cover="tooltip" title="Sil" onclick="$(this).closest(\'tr\').remove()"><i class="bx bx-trash"></i></a>';
            content += '</td>';

            return content;
        }

        var modal_module_template_multiple = function (item, split){

            var language_id = $('.media-tab-pane.active').data('language-id');

            var id = "";
            var template = "";
            var content = "";
            var inputs = '';
            for(var i=0; i < split.length; i++){
                content = '';
                inputs = '';
                template = "";
                id = uid();

                $.each(item, function (name, data) {
                    var value = data.value ? data.value : data.default ? data.default : '';
                    switch (data.type){
                        case 'textarea':
                            inputs += '<textarea name="datas[items]['+language_id+']['+id+']['+name+']" data-edit-name="'+name+'" class="d-none">'+value+'</textarea>';

                            break;
                        case 'image':
                            data.value = split[i];
                            value = data.value;
                            inputs += '<input type="{{ $input_type }}" name="settings[items]['+language_id+']['+id+']['+name+']" value="'+value+'" data-edit-name="'+name+'">';
                            break;
                        default:
                            if(name === "video_id") video_id = value;
                            if(name === "file_type") file_type = value;
                            inputs += '<input type="{{ $input_type }}" name="settings[items]['+language_id+']['+id+']['+name+']" value="'+value+'" data-edit-name="'+name+'">';
                            break;
                    }
                });

                content += '<td class="dragula-handle ui-draggable-handle"><i class="bx bx-dots-vertical"></i> </td>';


                $('.media-tab-pane.active table th[data-key]').each(function (index, th) {
                    if(item[$(th).data('key')]){
                        var data = item[$(th).data('key')];
                        if(data.type === "image") data.value = split[i];
                        var value = data.value ? data.value : data.default ? data.default : '';
                        var center = data.type === "image" ? 'class="text-center"' : '';
                        content += '<td '+center+'>';

                        switch (data.type){
                            case 'image':
                                if(file_type !== "file") {
                                    var res = '<span class="df-icon ' + file_type + '">' + file_type + "</span>";
                                } else {
                                    var ex = [];
                                    var value_full = value;
                                    if(value) {
                                        ex = value.toString().split(".");
                                        value = ex[ex.length - 1];
                                    }
                                    var res = '<span class="df-icon ' + value + '">' + value + "</span>";
                                    if(value === "jpg" || value === "jpeg" || value === "png" || value === "gif" || value === "svg")
                                        res = '<img src="'+value_full+'" width="150" class="img-fluid" alt="">';
                                    // var image = value ? '/img/icons/' + value + ".png" : '';
                                }
                                value = res;
                                break;
                            case 'select':
                                if(value){
                                    value = $('option[value="'+value+'"]').html();
                                }else{
                                    value = '-';
                                }
                                break;
                            case 'status':
                                if(value === 1){
                                    value = '<span class="badge bg-success">{{ "Aktif" }}</span>';
                                }else{
                                    value = '<span class="badge bg-danger">{{ "Pasif" }}</span>';
                                }
                                break;
                        }

                        content += value;
                        content += '</td>';
                        // console.log(template, "--------------------------------------------")

                    }
                });



                content += '<td class="text-center">';
                content += '<a href="javascript:;" class="btn btn-block text-primary" data-Cover="tooltip" title="Kopyala" onclick="modal_module_duplicate(this)"><i class="bx bxs-file-plus"></i></a>';
                content += '</td>';


                content += '<td class="text-center">';
                content += inputs;
                content += '<a href="javascript:;" class="btn btn-block text-primary" data-Cover="tooltip" title="Düzenle" onclick="modal_module_edit(this)"><i class="bx bx-pencil"></i></a>';
                content += '</td>';


                content += '<td class="text-center">';
                content += '<a href="javascript:;" class="btn btn-block text-danger" data-Cover="tooltip" title="Sil" onclick="$(this).closest(\'tr\').remove()"><i class="bx bx-trash"></i></a>';
                content += '</td>';
                template = content;

                $('.media-tab-pane.active tbody').append('<tr data-id="'+id+'">' + template + '</tr>');
            }
        }

        var uid = function () {
            return Math.floor(Math.random() * 26) + Date.now();
        }

        var noRecordTextDelete = function (){
            var id = document.getElementById("no-record");
            if (id){
                id.remove();
            }
        }

        $('#lfmFile').filemanager('image');
    </script>
@endsection
