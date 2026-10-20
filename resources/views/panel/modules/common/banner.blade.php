@extends('panel.modules.form')

@section("general-form")
    @php
        $parallax   = !empty($model["settings"]["parallax"]) ? $model["settings"]["parallax"] : 0;
        $container  = !empty($model["settings"]["container"]) ? $model["settings"]["container"] : 0;
        $column     = !empty($model["settings"]["column"]) ? $model["settings"]["column"] : 1;
    @endphp
    <div class="form-group mb-3">
        <label for="settings.parallax" class="form-label">Parallax Banner Mı?</label>
        <select class="select2 form-control" name="settings[parallax]" id="settings.parallax">
            <option value="1" @if(old("settings.parallax", $parallax) == 1) selected @endif>Aktif</option>
            <option value="0" @if(old("settings.parallax", $parallax) == 0) selected @endif>Pasif</option>
        </select>
    </div>

    <div class="form-group mb-3">
        <label for="settings.parallax" class="form-label">Container</label>
        <select class="select2 form-control" name="settings[container]" id="settings.container">
            <option value="1" @if(old("settings.container", $container) == 1) selected @endif>Açık</option>
            <option value="0" @if(old("settings.container", $container) == 0) selected @endif>Kapalı</option>
        </select>
    </div>

    <div class="form-group mb-3">
        <label for="settings.column" class="form-label">Kolon Sayısı</label>
        <select class="select2 form-control" name="settings[column]" id="settings.column">
            <option value="1" @if(old("settings.column", $column) == 1) selected @endif>1 Kolon</option>
            <option value="2" @if(old("settings.column", $column) == 2) selected @endif>2 Kolon</option>
            <option value="3" @if(old("settings.column", $column) == 3) selected @endif>3 Kolon</option>
        </select>
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
                    $title = !empty($model["settings"]["translation"][$lang]["title"]) ? $model["settings"]["translation"][$lang]["title"] : '';
                @endphp

                <div class="tab-pane fade @if($loop->first) show active @endif" id="tab-content-{{$lang_code}}" data-language-id="{{ $lang }}" role="tabpanel">

                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="settings.column" class="form-label">Başlık</label>
                            <input type="text" class="form-control" name="settings[translation][{{$lang}}][title]" value="{{old("settings.translation.".$lang.".title", $title)}}">
                        </div>
                    </div>

                    <h5 class="card-header pt-3">Görseller</h5>

                    <div class="table-responsive text-nowrap">
                        <table class="table table-bordered table-hover table-sortable" data-key="items">
                            <thead class="table-dark">
                            <tr>
                                <th class="text-center" width="1">Sırala</th>
                                <th data-key="image" class="text-center" width="150">Görsel</th>
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
                                        <td><img src="{{asset($item["image"])}}" alt="" width="150" class="img-preview rounded"></td>
                                        <td>{!! $item["title"] !!}</td>

                                        <td class="text-center">
                                            <a href="javascript:;" class="btn btn-block text-primary" data-popup="tooltip" title="Kopyala" onclick="modal_module_duplicate(this)">
                                                <i class="bx bxs-file-plus"></i>
                                            </a>
                                        </td>

                                        <td class="text-center">
                                            <input type="hidden" name="settings[items][{{$lang}}][{{$key}}][title]" value="{{$item["title"]}}" data-edit-name="title">
                                            <input type="hidden" name="settings[items][{{$lang}}][{{$key}}][description]" value="{{$item["description"]}}" data-edit-name="description">
                                            <input type="hidden" name="settings[items][{{$lang}}][{{$key}}][button_name]" value="{{$item["button_name"]}}" data-edit-name="button_name">
                                            <input type="hidden" name="settings[items][{{$lang}}][{{$key}}][button_link]" value="{{$item["button_link"]}}" data-edit-name="button_link">
                                            <input type="hidden" name="settings[items][{{$lang}}][{{$key}}][target]" value="{{!empty($item["target"]) ? $item["target"] : "_self"}}" data-edit-name="target">
                                            <input type="hidden" name="settings[items][{{$lang}}][{{$key}}][image]" value="{{asset($item["image"])}}" data-edit-name="image">
                                            <input type="hidden" name="settings[items][{{$lang}}][{{$key}}][sort_order]" value="{{ !empty($item["sort_order"]) ? $item["sort_order"] : 999 }}" data-edit-name="sort_order">
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
                    <form id="modal_module_id" onsubmit="return modal_module_submit(event)">
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
                                    <textarea type="text" name="description" data-value="" data-type="text" class="form-control editor-ck" data-height="300"></textarea>
                                </div>
                            </div>

                            <div class="col-md-12 col-12">
                                <div class="form-group mb-3">
                                    <label class="form-label">Sıra Numarası</label>
                                    <input type="text" name="sort_order" data-value="999" data-type="text" class="form-control" />
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <select name="target" id="target" class="select2" data-value="_self" data-type="select">
                                                <option value="_self">Geçerli Pencere</option>
                                                <option value="_blank">Yeni Pencere</option>
                                            </select>
                                        </div>
                                        <input type="text" name="button_link" data-value="" data-type="text" class="form-control" placeholder="Link" />
                                        <input type="text" name="button_name" data-value="" data-type="text" class="form-control" placeholder="Button Adı"/>
                                    </div>
                                </div>
                            </div>


                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label class="form-label">Görsel</label>
                                    <div class="input-group">
                                        <input id="thumbnailImg" class="form-control" type="text" name="image" readonly required data-value="" data-type="image">
                                        <div class="input-group-btn">
                                            <a id="lfmImage" data-input="thumbnailImg" data-preview="holder" class="btn btn-primary text-white"><i class="fa fa-picture-o"></i> Görsel Seç</a>
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
        $('#lfmImage').filemanager('image');
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

            $('.tab-pane.active tbody').append(tr);
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
                $('.tab-pane.active tbody').find('[data-id="'+id+'"]').html(template);
            }else{
                $('.tab-pane.active tbody').append('<tr data-id="'+id+'">' + template + '</tr>');
            }

            $('#modal_module').modal('hide');
            // kayıt bulunamadı satırını silelim.
            noRecordTextDelete();

            return false;
        }

        function modal_module_template(id, item) {
            var content = '';
            var language_id = $('.tab-pane.active').data('language-id');

            var inputs = '';
            $.each(item, function (name, data) {
                var value = data.value ? data.value : data.default ? data.default : '';
                switch (data.type){
                    case 'textarea':
                        inputs += '<textarea name="settings[items]['+language_id+']['+id+']['+name+']" data-edit-name="'+name+'" class="d-none">'+value+'</textarea>';

                        break;
                    default:
                        inputs += '<input type="{{ $input_type }}" name="settings[items]['+language_id+']['+id+']['+name+']" value="'+value+'" data-edit-name="'+name+'">';
                        break;
                }
            });

            content += '<td class="dragula-handle ui-draggable-handle"><i class="bx bx-dots-vertical"></i> </td>';

            $('.tab-pane.active table th[data-key]').each(function (index, th) {
                if(item[$(th).data('key')]){
                    content += '<td>';
                    var data = item[$(th).data('key')];
                    var value = data.value ? data.value : data.default ? data.default : '';
                    switch (data.type){
                        case 'image':
                            var image = value ? value : '/uploads/placeholder.png';
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
        $('#lfm').filemanager('image');
    </script>
@endsection
