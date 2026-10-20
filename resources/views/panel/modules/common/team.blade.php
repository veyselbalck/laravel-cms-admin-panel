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
        </select>
        <small>Kolon Sayısı Konsept görsel şablonlarında kullanılmaktadır.</small>
    </div>
@endsection

@section("module-form")
    <div class="text-end mb-3">
        <button type="button" class="btn btn-dark"  onclick="modal_module_add()"><i class="bx bx-plus"></i> Ekle</button>
    </div>

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
                <div class="tab-pane fade @if($loop->first) show active @endif" id="tab-content-{{$lang_code}}" data-language-id="{{ $lang }}" role="tabpanel">
                    <div class="card-body mb-3">
                        <div class="form-group mb-3">
                            <label class="form-label">Başlık</label>
                            <input type="text" name="settings[translation][{{$lang}}][title]" value="{{ old('settings.translation.'.$lang.'.title', $title) }}" class="form-control" />
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
                </div>
            @endforeach
        </div>


        <h5 class="card-header pt-0">Ekip Listesi</h5>

        <div class="table-responsive text-nowrap list-items">
            <table class="table table-bordered table-hover table-sortable" data-key="items">
                <thead class="table-dark">
                <tr>
                    <th class="text-center" width="1">Sırala</th>
                    <th data-key="image" class="text-center" width="150">Görsel</th>
                    <th data-key="name" width="150">Ad Soyad</th>
                    <th class="text-center" width="1">Kopyala</th>
                    <th class="text-center" width="1">Düzenle</th>
                    <th class="text-center" width="1">Sil</th>
                </tr>
                </thead>
                <tbody class="table-border-bottom-0" data-tbody="items">
                @if(!empty($items2))
                    @foreach($items2 as $key => $item)
                        <tr data-id="{{$key}}">
                            <td class="dragula-handle ui-draggable-handle"><i class="bx bx-dots-vertical"></i> </td>
                            <td><img src="{{asset($item["image"])}}" alt="" width="150" class="img-preview rounded"></td>
                            <td>{{$item["name"]}}</td>

                            <td class="text-center">
                                <a href="javascript:;" class="btn btn-block text-primary" data-popup="tooltip" title="Kopyala" onclick="modal_module_duplicate(this)">
                                    <i class="bx bxs-file-plus"></i>
                                </a>
                            </td>

                            <td class="text-center">
                                <input type="hidden" name="settings[items2][{{$key}}][name]" value="{{$item["name"]}}" data-edit-name="name">
                                @foreach(getLanguagesByCodeId() as $lang_code => $lang)
                                <input type="hidden" name="settings[items2][{{$key}}][title_{{$lang_code}}]" value="{{$item["title_" . $lang_code]}}" data-edit-name="title_{{$lang_code}}">
                                <input type="hidden" name="settings[items2][{{$key}}][siralama_{{$lang_code}}]" value="{{$item["siralama_" . $lang_code]}}" data-edit-name="siralama_{{$lang_code}}">
                              @endforeach
                                <input type="hidden" name="settings[items2][{{$key}}][image]" value="{{asset($item["image"])}}" data-edit-name="image">
                                <input type="hidden" name="settings[items2][{{$key}}][sort_order]" value="{{ !empty($item["sort_order"]) ? $item["sort_order"] : 999 }}" data-edit-name="sort_order">

{{--                                <input type="hidden" name="settings[items2][{{$key}}][facebook]" value="{{$item["facebook"]}}" data-edit-name="facebook">--}}
{{--                                <input type="hidden" name="settings[items2][{{$key}}][twitter]" value="{{$item["twitter"]}}" data-edit-name="twitter">--}}
{{--                                <input type="hidden" name="settings[items2][{{$key}}][instagram]" value="{{$item["instagram"]}}" data-edit-name="instagram">--}}
{{--                                <input type="hidden" name="settings[items2][{{$key}}][linkedin]" value="{{$item["linkedin"]}}" data-edit-name="linkedin">--}}
{{--                                <input type="hidden" name="settings[items2][{{$key}}][youtube]" value="{{$item["youtube"]}}" data-edit-name="youtube">--}}
{{--                                <input type="hidden" name="settings[items2][{{$key}}][tiktok]" value="{{$item["tiktok"]}}" data-edit-name="tiktok">--}}
{{--                                <input type="hidden" name="settings[items2][{{$key}}][behance]" value="{{$item["behance"]}}" data-edit-name="behance">--}}
{{--                                <input type="hidden" name="settings[items2][{{$key}}][pinterest]" value="{{$item["pinterest"]}}" data-edit-name="pinterest">--}}
{{--                                <input type="hidden" name="settings[items2][{{$key}}][github]" value="{{$item["github"]}}" data-edit-name="github">--}}
                                <a href="javascript:;" class="btn btn-block text-primary" data-popup="tooltip" title="Düzenle" onclick="modal_module_edit(this)"><i class="bx bx-pencil"></i></a>
                            </td>

                            <td class="text-center">
                                <a href="javascript:;" class="btn btn-block text-danger" data-popup="tooltip" title="Sil" onclick="$(this).closest('tr').remove()">
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
                                    <label class="form-label">Ad Soyad</label>
                                    <input type="text" name="name" data-value="" data-type="text" class="form-control" />
                                </div>
                            </div>

                            @foreach(getLanguagesByCodeId() as $lang_code => $lang)
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label class="form-label">Ünvan / <span class="fw-bold text-uppercase">{{$lang_code}}</span></label>
                                    <input type="text" name="title_{{$lang_code}}" data-value="" data-type="text" class="form-control" />
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label class="form-label">Sıralama / <span class="fw-bold text-uppercase">{{$lang_code}}</span></label>
                                    <input type="text" name="siralama_{{$lang_code}}" data-value="" data-type="text" class="form-control" />
                                </div>
                            </div>
                            @endforeach

                            <div class="col-12">
                                <div class="row">
{{--                                    @php($socials = ['facebook', 'twitter', 'instagram', 'linkedin', 'youtube', 'tiktok', 'behance', 'pinterest', 'github', ])--}}

{{--                                    @foreach($socials as $v)--}}
{{--                                        <div class="form-group col-md-6 col-12 mb-3">--}}
{{--                                            <label class="form-label text-capitalize">{{$v}}</label>--}}
{{--                                            <input type="text" name="{{$v}}" data-value="" data-type="text" class="form-control" />--}}
{{--                                        </div>--}}
{{--                                    @endforeach--}}


                                    <div class="form-group col-md-6 col-12 mb-3">
                                        <label class="form-label">Sıra Numarası</label>
                                        <input type="text" name="sort_order" data-value="999" data-type="text" class="form-control" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label class="form-label">Profil Resmi</label>
                                    <div class="input-group">
                                        <input id="thumbnailFile" class="form-control" type="text" name="image" readonly required data-value="" data-type="image">
                                        <div class="input-group-btn">
                                            <a id="lfmFile" data-input="thumbnailFile" data-preview="holder2" class="btn btn-primary text-white">
                                                <i class="fa fa-picture-o"></i> Görsel Seç
                                            </a>
                                        </div>
                                    </div>
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
    @php($input_type ='hidden')
    <script>
        $('#lfmFile').filemanager('image');
        var edit_id = -1;
        var input_elements = 'input, select, textarea';
        function modal_module_add() {

            edit_id = -1;
            $('[data-placeholder]').each(function () {
                $(this).attr('src', '/panel/img/full-with-img.png')
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

            $('.list-items tbody').append(tr);
        }

        function modal_module_edit(element) {
            $('#modal_module [type="submit"]').text('Güncelle');

            var tr = $(element).closest('tr');

            edit_id = tr.data('id');

            $('#modal_module .modal-body .button-image-clear').addClass('d-none');
            $('[data-placeholder]').each(function () {
                $(this).attr('src', '/panel/img/full-with-img.png')
            })

            $.each(tr.find(input_elements), function () {
                var key = $(this).data('edit-name');
                var val = $(this).val();
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

            if(edit_id != -1){
                $('.list-items tbody').find('[data-id="'+id+'"]').html(template);
            }else{
                $('.list-items tbody').append('<tr data-id="'+id+'">' + template + '</tr>');
            }

            $('#modal_module').modal('hide');
            // kayıt bulunamadı satırını silelim.
            noRecordTextDelete();

            return false;
        }

        function modal_module_template(id, item) {
            var content = '';

            var inputs = '';
            $.each(item, function (name, data) {
                var value = data.value ? data.value : data.default ? data.default : '';
                switch (data.type){
                    case 'textarea':
                        inputs += '<textarea name="settings[items2]['+id+']['+name+']" data-edit-name="'+name+'" class="d-none">'+value+'</textarea>';

                        break;
                    default:
                        inputs += '<input type="{{ $input_type }}" name="settings[items2]['+id+']['+name+']" value="'+value+'" data-edit-name="'+name+'">';
                        break;
                }
            });


            content += '<td class="dragula-handle ui-draggable-handle"><i class="bx bx-dots-vertical"></i> </td>';

            $('.list-items table th[data-key]').each(function (index, th) {
                if(item[$(th).data('key')]){
                    content += '<td>';
                    var data = item[$(th).data('key')];
                    var value = data.value ? data.value : data.default ? data.default : '';
                    switch (data.type){
                        case 'image':
                            var image = value ? value : '/panel/img/full-with-img.png';
                            value = '<img src="'+image+'" alt="" width="150" class="img-preview rounded">';
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
            content += '<a href="javascript:;" class="btn btn-block text-primary" data-popup="tooltip" title="Kopyala" onclick="modal_module_duplicate(this)"><i class="bx bxs-file-plus"></i></a>';
            content += '</td>';


            content += '<td class="text-center">';
            content += inputs;
            content += '<a href="javascript:;" class="btn btn-block text-primary" data-popup="tooltip" title="Düzenle" onclick="modal_module_edit(this)"><i class="bx bx-pencil"></i></a>';
            content += '</td>';


            content += '<td class="text-center">';
            content += '<a href="javascript:;" class="btn btn-block text-danger" data-popup="tooltip" title="Sil" onclick="$(this).closest(\'tr\').remove()"><i class="bx bx-trash"></i></a>';
            content += '</td>';

            return content;
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
    </script>
@endsection
