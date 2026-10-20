@extends('panel.modules.form')

@section("general-form")
    @php
        $template   = !empty($model["settings"]["template"]) ? $model["settings"]["template"] : "main";
        $column     = !empty($model["settings"]["column"]) ? $model["settings"]["column"] : 1;
    @endphp
    <div class="form-group mb-3">
        <label for="settings.parallax" class="form-label">Menü Şablonu</label>
        <select class="select2 form-control" name="settings[template]" id="settings.template">
            @foreach(menuTypes() as $k => $v)
                <option value="{{$k}}" @if(old("settings.template", $template) == $k) selected @endif>{{$v}}</option>
            @endforeach
        </select>
    </div>

{{--    <div class="form-group mb-3">--}}
{{--        <label for="settings.column" class="form-label">Kolon Sayısı</label>--}}
{{--        <select class="select2 form-control" name="settings[column]" id="settings.column">--}}
{{--            <option value="1" @if(old("settings.column", $column) == 1) selected @endif>1 Kolon</option>--}}
{{--            <option value="2" @if(old("settings.column", $column) == 2) selected @endif>2 Kolon</option>--}}
{{--            <option value="3" @if(old("settings.column", $column) == 3) selected @endif>3 Kolon</option>--}}
{{--        </select>--}}
{{--        <small>Kolon sayısı sadece footer şablonu için kullanılacaktır.</small>--}}
{{--    </div>--}}
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
                    $items = !empty($model["settings"]["translation"]["items"][$lang]) ? $model["settings"]["translation"]["items"][$lang] : '';
                @endphp
                <div class="tab-pane fade @if($loop->first) show active @endif" id="tab-content-{{$lang_code}}" data-language-id="{{ $lang }}" role="tabpanel">
                    <textarea name="settings[translation][items][{{$lang}}]" id="settings_translation_items_{{$lang}}" class="form-control d-none">{{ $items }}</textarea>
                    <div class="card-body">
                        <div class="dd nestable">
                            <ol class="dd-list"></ol>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@section('modals')
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <div class="modal fade" id="modal_module" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-simple">
            <div class="modal-content p-3 p-md-5">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="text-center mb-4">
                        <h3 class="modal-title modal-title-add">Ekle</h3>
                        <h3 class="modal-title modal-title-update d-none">Güncelle</h3>
                    </div>

                    <form method="post" id="modal_module_id">
                        <div class="modal-body bg-lighter">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-text bg-dark"><i class="bx bx-search" style="color: #fff"></i></span>
                                            <input type="text" class="form-control ui-autocomplete-input" id="autocomplete" placeholder="İçeriklerde ara" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-body">
                            <input type="hidden" name="id" value="" class="form-control data-id" />

                            <div class="form-group mb-3">
                                <label for="name">Menü Adı</label>
                                <input type="text" name="name" value="" class="form-control" />
                            </div>

                            <div class="form-group mb-3">
                                <label for="href">Menü Linki</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <select name="target" id="target" class="select2" >
                                            <option value="_self">Aynı Sayfada Aç</option>
                                            <option value="_blank">Yeni Pencerede Aç</option>
                                        </select>
                                    </div>
                                    <input type="text" name="href" value="" class="form-control"  />
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="status">Durumu</label>
                                <select name="status" id="status" class="select2" >
                                    <option value="1">Aktif</option>
                                    <option value="0">Pasif</option>
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label for="class">Menü Class</label>
                                <input type="text" name="class" value="" class="form-control" />
                            </div>
                        </div>

                        <div class="modal-footer pt-3 bg-white">
                            <button type="submit" class="btn btn-dark">Kaydet</button>
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

        var datas = [];
        $('#autocomplete').autocomplete({
            source: function(request, response) {
                var params = {
                    filter_name: request.term,
                    language_id:$('.tab-pane.active').data('language-id')
                }

                $.ajax( {
                    url: '/admin/json/contents',
                    dataType: "json",
                    data: params,
                    success: function( data ) {
                        console.log(data)
                        datas = data.map(function(currentValue, index, arr) {
                            return {
                                label: currentValue.label,
                                value: currentValue.value,
                                href: currentValue.href
                            };
                        });
                    }
                });
                response( datas );
            },
            select: function(event, ui) {
                event.preventDefault();
                $('#autocomplete').val("");
                $('#modal_module_id').find('[name="name"]').val(ui.item.value).focus();
                $('#modal_module_id').find('[name="href"]').val(ui.item.href);
            },
        }).on('keyup', function(event) {
            if ($(event.target).val().length == 0) $('#selection-ajax').html('');
        }).data('ui-autocomplete')._renderItem = function( ul, item ) {
            var $div = $("<div></div>").text(item.label),
                searchText  = $.trim(this.term).toLowerCase(),
                currentNode = $div.get(0).firstChild,
                matchIndex, newTextNode, newSpanNode;
            while ((matchIndex = currentNode.data.toLowerCase().indexOf(searchText)) >= 0) {
                newTextNode = currentNode.splitText(matchIndex);
                currentNode = newTextNode.splitText(searchText.length);
                newSpanNode = document.createElement("span");
                newSpanNode.className = "highlight";
                currentNode.parentNode.insertBefore(newSpanNode, currentNode);
                newSpanNode.appendChild(newTextNode);
            }

            return $("<li></li>").append($div).appendTo(ul);
        };


        document.addEventListener('DOMContentLoaded', function() {
            $('.dd').each(function () {
                var textarea = $(this).closest('.tab-pane').find('textarea')

                var opt = {
                    contentClass:'dd-content d-flex',
                    contentCallback:function (item) {
                        return modal_module_template(item)
                    }
                }
                if(textarea.val()){
                    opt.json = textarea.val()
                }

                $(this).nestable(opt).on('change', function (e) {
                    $(textarea).val(window.JSON.stringify($(e.target).nestable('serialize')));
                });
                $(this).nestable('collapseAll');
            })

            $('#modal_module_id').submit (function(e) {

                e.preventDefault();

                var item = {};
                $.map($(this).serializeArray(), function(n, i){ item[n['name']] = n['value']; });

                if($('[data-id = "'+item.id+'"]').length){
                    $.each(item, function (key, value) {
                        $('[data-id = "'+item.id+'"]').data(key, value)
                        $('[data-id = "'+item.id+'"]').attr('data-' +key, value);
                    })
                    $('[data-id = "'+item.id+'"]').find('.dd-content:first').html(modal_module_template(item));
                    $('.tab-pane.active .dd').nestable().trigger('change');
                }else{
                    $('.tab-pane.active .dd').nestable('add', item).trigger('change');
                }

                $('#modal_module').modal('hide');

                return false;
            });
        });

        function modal_module_add() {
            $('#modal_module .modal-body').find('input').each(function () {
                $(this).val('');
            })

            $('#modal_module .modal-body').find('select').each(function () {
                $(this).val($(this).find('option:eq(0)').val()).trigger('change');
            })

            $('#modal_module .modal-body .data-id').val(Math.floor(Math.random() * 26) + Date.now());

            $('.modal-title-add').removeClass('d-none');
            $('.modal-title-update').addClass('d-none');

            $('#modal_module [type="submit"]').text('Ekle');

            $('#modal_module').modal('show');
        }
        function modal_module_edit(id) {
            $('#modal_module [type="submit"]').text('Güncelle');

            $.each($('li[data-id='+id+']').data(), function (name, item) {
                $('#modal_module .modal-body [name="'+name+'"]').val(item).trigger('change');
            });

            $('.modal-title-add').addClass('d-none');
            $('.modal-title-update').removeClass('d-none');

            $('#modal_module').modal('show');
        }
        function modal_module_remove(id) {
            $('.dd').nestable('remove', id).trigger('change');
        }
        function modal_module_template(item) {
            var content = '';

            content += '<div class="d-flex align-self-center">';
            content += item.name;
            content += '</div>';


            content += '<div class="d-flex align-self-center ms-3">';
            content += '<code>Target: '+item.target+'</code>';
            content += '</div>';

            if(item.class){
                content += '<div class="d-flex align-self-center ms-3">';
                content += '<code>Class: '+item.class+'</code>';
                content += '</div>';
            }
            content += '<div class="d-flex align-self-center ms-auto me-3 dd-nodrag">';
            if(item.href){
                content += '<code>Url: <a href="'+item.href+'" target="_blank">'+item.href+'</a> </code>';
            }
            content += '</div>';


            content += '<div class="d-flex align-self-center me-3">';
            content += parseInt(item.status.toString()) ? '<span class="badge bg-success">Aktif</span>' : '<span class="badge bg-danger">Pasif</span>';
            content += '</div>';

            content += '<div class="dd-nodrag btn-group btn-group-sm">';
            content += '<button type="button" class="btn btn-sm btn-dark btn-icon" data-popup="tooltip" title="Edit" onclick="modal_module_edit('+item.id+')"><i class="icon-pencil7"></i></button>';
            content += '<button type="button" class="btn btn-sm btn-danger btn-icon" data-popup="tooltip" title="Destroy" onclick="modal_module_remove('+item.id+')"><i class="icon-trash"></i></button>';
            content += '</div>';

            return content;
        }


        var autoComplete = function (item, url, callback, source) {
            $(item).focus(function(){
                if($(this).val() == ""){
                    $(this).val('');
                    $(this).keydown();
                }
            });

            $(item).autocomplete({
                minLength: 0,
                'source': function(request, response) {
                    var params = {
                        filter_name: request.term
                    }
                    if(source){
                        params = source(request);
                    }

                    $.ajax({
                        url: url,
                        dataType: "json",
                        data: params,
                        success: function(json) {
                            response(json);
                        },
                        beforeSend: function( xhr ) {
                            $(item).parent().addClass('ui-autocomplete-processing ui-autocomplete-loading');
                            $(item).removeClass('is-invalid');
                        },
                        complete:function () {
                            $(item).parent().removeClass('ui-autocomplete-processing');
                        }
                    });
                },

                'select': function(event, ui) {
                    callback(ui.item, item);
                    return false;
                }
            });
        }
    </script>
@endsection
