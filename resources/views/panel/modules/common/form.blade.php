@extends('panel.modules.form')

@section("general-form")
    @php
        $mail_to   = !empty($model["settings"]["mail_to"]) ? $model["settings"]["mail_to"] : "";
        $mail_bcc   = !empty($model["settings"]["mail_bcc"]) ? $model["settings"]["mail_bcc"] : "";
        $mail_success   = !empty($model["settings"]["mail_success"]) ? $model["settings"]["mail_success"] : "";
        $form_body_edit   = !empty($model["settings"]["form_body_edit"]) ? $model["settings"]["form_body_edit"] : "";
        $form_body   = !empty($model["settings"]["form_body"]) ? $model["settings"]["form_body"] : "";
        $form_required   = !empty($model["settings"]["form_required"]) ? $model["settings"]["form_required"] : "";
    @endphp

    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="form-group">
                <label for="mail_to" class="text-danger form-label">Formun Gönderileceği Mail Adresleri *</label>
                <input type="text" name="settings[mail_to]" id="mail_to" value="{{old("settings.mail_to", $mail_to)}}" class="form-control" required>
                <small class="text-muted">Formun birden çok mail adresine gitmesi için noktalı virgül kullanabilirsiniz</small><br>
                <small class="text-muted">Örnek: <code>{{'mail@'.str_replace(["https://", "http://"], "", config("app.url"))}}; {{'mail2@'.str_replace(["https://", "http://"], "", config("app.url"))}}</code></small>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="form-group">
                <label for="mail_bcc" class="form-label">Formun Gönderileceği Mail Adresleri BCC</label>
                <input type="text" name="settings[mail_bcc]" id="mail_bcc" value="{{old("settings.mail_bcc", $mail_bcc)}}" class="form-control">
                <small class="text-muted">Formun birden çok mail adresine gitmesi için noktalı virgül kullanabilirsiniz</small><br>
                <small class="text-muted">Örnek: <code>{{'mail@'.str_replace(["https://", "http://"], "", config("app.url"))}}; {{'mail2@'.str_replace(["https://", "http://"], "", config("app.url"))}}</code></small>
            </div>
        </div>
    </div>

    <div class="d-none">
        <div class="form-group">
            <textarea name="settings[form_body_edit]" class="form-control">{{ $form_body_edit }}</textarea>
        </div>

        <div class="form-group">
            <textarea name="settings[form_body]" class="form-control" rows="10">{{ $form_body }}</textarea>
        </div>
        <div class="form-group">
            <textarea name="settings[form_required]" class="form-control" >{{ $form_required }}</textarea>
        </div>
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
                    $mail_success   = !empty($model["settings"]["translation"][$lang]["mail_success"]) ? $model["settings"]["translation"][$lang]["mail_success"] : '';
                @endphp
                <div class="tab-pane fade @if($loop->first) show active @endif" id="tab-content-{{$lang_code}}" data-language-id="{{ $lang }}" role="tabpanel">
                    <div class="card-body mb-3">
                        <div class="form-group mb-3">
                            <label class="form-label">Başlık</label>
                            <input type="text" name="settings[translation][{{$lang}}][title]"
                                   id="settings_translation_{{$lang}}_title"
                                   value="{{ old('settings.translation.'.$lang.'.title', $title) }}" class="form-control" />
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Açıklama</label>
                            <input type="text" name="settings[translation][{{$lang}}][description]" value="{{ old('settings.translation.'.$lang.'.description', $description) }}" class="form-control" />
                        </div>

                        <div class="form-group mb-3">
                            <label for="mail_success" class="text-danger form-label">Form Başarı Mesajı *</label>
                            <textarea name="settings[translation][{{$lang}}][mail_success]" class="form-control" required>{{ old('settings.translation.'.$lang.'.mail_success', $mail_success) }}</textarea>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@section('FormNot')
    <div class="card form-editor-container">
        <div class="card-header bg-transparent header-elements-inline">
            <h6 class="card-title">Form Elements</h6>
            <div class="header-elements">
                <div class="list-icons">
                    <a class="list-icons-item" data-action="fullscreen"></a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-8 col-lg-9">
                    <div class="form-editor form-editor-empty" data-content="Sağ taraftan bu alana bir bileşen sürükleyin.">{!! $form_body_edit !!}</div>
                </div>
                <div class="col-md-4  col-lg-3">
                    <div class="sidebar sidebar-light sidebar-component position-static w-100 d-block">
                        <div class="sidebar-content overflow-visible">

                            <!-- Navigation -->
                            <div class="sidebar-section">
                                <ul class="nav nav-sidebar" data-nav-type="collapsible" id="form-builder-tools">
                                    <li class="nav-item-header">
                                        <div class="text-uppercase font-size-sm line-height-sm">CONTAINERS</div>
                                    </li>

                                    <li class="nav-item">
                                        <a href="javascript:;" class="nav-link draggable-row"><i class="icon-insert-template"></i>ROW</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="javascript:;" class="nav-link draggable-col"><i class="icon-grid3"></i>COLUMN</a>
                                    </li>

                                    <li class="nav-item-header">
                                        <div class="text-uppercase font-size-sm line-height-sm">FORM ELEMENTS</div>
                                    </li>

                                    <li class="nav-item">
                                        <a href="javascript:;" class="nav-link draggable-element" data-element="input"><i class="icon-text-width"></i>INPUT</a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="javascript:;" class="nav-link draggable-element" data-element="textarea"><i class="icon-file-text"></i>TEXTAREA</a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="javascript:;" class="nav-link draggable-element" data-element="dropdown"><i class="icon-menu2"></i>DROPDOWN</a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="javascript:;" class="nav-link draggable-element" data-element="dropdown_country"><i class="icon-menu2"></i>DROPDOWN COUNTRY</a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="javascript:;" class="nav-link draggable-element" data-element="dropdown_city"><i class="icon-menu2"></i>DROPDOWN CITY</a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="javascript:;" class="nav-link draggable-element" data-element="check_radio" data-type="checkbox"><i class="icon-checkbox-checked"></i>CHECKBOX</a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="javascript:;" class="nav-link draggable-element" data-element="check_radio" data-type="radio"><i class="icon-radio-checked"></i>RADIO</a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="javascript:;" class="nav-link draggable-element" data-element="input_file"><i class="icon-file-upload"></i>INPUT FILE</a>
                                    </li>


                                    <li class="nav-item-header">
                                        <div class="text-uppercase font-size-sm line-height-sm">HTML</div>
                                    </li>

                                    <li class="nav-item">
                                        <a href="javascript:;" class="nav-link draggable-element" data-element="h1"><i class="icon-spell-check"></i>H1, H2, H3, H4, H5, H6</a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="javascript:;" class="nav-link draggable-element" data-element="p"><i class="icon-typography"></i>PARAGRAPH</a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="javascript:;" class="nav-link draggable-element" data-element="hr"><i class="icon-pagebreak"></i>HR</a>
                                    </li>

                                </ul>


                            </div>
                            <!-- /navigation -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')

    <div id="modal_input" class="modal fade">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header pb-3 bg-white">
                    <h5 class="modal-title">Düzenle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" onsubmit="return false;">
                        <div class="form-group required mb-3">
                            <label class="form-label">Type</label>
                            <select class="form-control input_type" onchange="FormElements.setAttr('type', this.value)">
                                <option value="text">Text</option>
                                <option value="email">Email</option>
                                <option value="tel">Phone</option>
                                <option value="number">Number</option>
                                <option value="date">Date</option>
                                <option value="time">Time</option>
                                <option value="datetime-local">Date Time</option>
                            </select>
                        </div>
                        <div class="form-group required mb-3">
                            <label class="form-label">Label</label>
                            <input type="text" value="" class="form-control input_name" onchange="FormElements.setAttr('name', this.value)" required />
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Required</label>
                            <select class="form-control input_required" onchange="FormElements.setRequired(this.value)">
                                <option value="required">Evet</option>
                                <option value="">Hayır</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Helper</label>
                            <input type="text" value="" class="form-control input_helper" onchange="FormElements.helper.setValue(this.value)" />

                        </div>
                    </form>
                </div>
                <div class="modal-footer pt-3 bg-white">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Kapat</button>
                </div>
            </div>
        </div>
    </div>

    <div id="modal_textarea" class="modal fade">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header pb-3 bg-white">
                    <h5 class="modal-title">Düzenle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" onsubmit="return false;">
                        <div class="form-group required mb-3">
                            <label class="form-label">Label</label>
                            <input type="text" value="" class="form-control input_name" onchange="FormElements.setAttr('name', this.value)" required />
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Rows</label>
                            <input type="number" value="3" class="form-control input_rows" onchange="FormElements.setAttr('rows', this.value)" />

                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Required</label>
                            <select class="form-control input_required" onchange="FormElements.setRequired(this.value)">
                                <option value="required">Evet</option>
                                <option value="">Hayır</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Helper</label>
                            <input type="text" value="" class="form-control input_helper" onchange="FormElements.helper.setValue(this.value)" />

                        </div>
                    </form>
                </div>
                <div class="modal-footer pt-3 bg-white">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Kapat</button>
                </div>
            </div>
        </div>
    </div>

    <div id="modal_dropdown" class="modal fade">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header pb-3 bg-white">
                    <h5 class="modal-title">Düzenle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" onsubmit="return false;">

                        <div class="form-group required mb-3">
                            <label class="form-label">Label</label>
                            <input type="text" value="" class="form-control input_name" onchange="FormElements.setAttr('name', this.value)" required />
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Required</label>
                            <select class="form-control input_required" onchange="FormElements.setRequired(this.value)">
                                <option value="required">Evet</option>
                                <option value="">Hayır</option>
                            </select>
                        </div>

                        <div class="form-group mb-0">
                            <div class="form-group mb-3">
                                <label class="form-label">Helper</label>
                                <input type="text" value="" class="form-control input_helper" onchange="FormElements.helper.setValue(this.value)" />
                            </div>
                        </div>

                        <fieldset class="position-relative dropdown-options">
                            <legend class="text-uppercase font-size-sm font-weight-bold">DROPDOWN OPTIONS</legend>

                            <table class="table table-bordered table-sm dropdown-option-items">
                                <thead>
                                <tr>
                                    <th>Text</th>
                                    <th>Value</th>
                                    <th width="1" class="text-center p-1 pt-0 pb-0">
                                        <a href="javascript:;" class="btn btn-dark btn-sm btn-icon" onclick="FormElements.dropdown.addOption()" title="Add Option"><i class="icon-plus22"></i></a>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>

                        </fieldset>

                    </form>
                </div>
                <div class="modal-footer pt-3 bg-white">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Kapat</button>
                </div>
            </div>
        </div>
    </div>

    <div id="modal_dropdown_country" class="modal fade">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header pb-3 bg-white">
                    <h5 class="modal-title">Düzenle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" onsubmit="return false;">

                        <div class="form-group required mb-3">
                            <label class="form-label">Label</label>
                            <input type="text" value="" class="form-control input_name" onchange="FormElements.setAttr('name', this.value)" required />
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Required</label>
                            <select class="form-control input_required" onchange="FormElements.setRequired(this.value)">
                                <option value="required">Evet</option>
                                <option value="">Hayır</option>
                            </select>
                        </div>

                        <div class="form-group mb-0">
                            <div class="form-group mb-3">
                                <label class="form-label">Helper</label>
                                <input type="text" value="" class="form-control input_helper" onchange="FormElements.helper.setValue(this.value)" />
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer pt-3 bg-white">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Kapat</button>
                </div>
            </div>
        </div>
    </div>

    <div id="modal_dropdown_city" class="modal fade">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header pb-3 bg-white">
                    <h5 class="modal-title">Düzenle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" onsubmit="return false;">

                        <div class="form-group required mb-3">
                            <label class="form-label">Label</label>
                            <input type="text" value="" class="form-control input_name" onchange="FormElements.setAttr('name', this.value)" required />
                        </div>

                        <div class="form-group mb-0">
                            <div class="form-group mb-3">
                                <label class="form-label">Country Target</label>
                                <select class="form-control target_country" onchange="FormElements.dropdown_city.target(null, this.value)">
                                    <option value="">@lang('Selected')</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Required</label>
                            <select class="form-control input_required" onchange="FormElements.setRequired(this.value)">
                                <option value="required">Evet</option>
                                <option value="">Hayır</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Helper</label>
                            <input type="text" value="" class="form-control input_helper" onchange="FormElements.helper.setValue(this.value)" />

                        </div>

                    </form>
                </div>
                <div class="modal-footer pt-3 bg-white">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Kapat</button>
                </div>
            </div>
        </div>
    </div>

    <div id="modal_checkbox" class="modal fade">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header pb-3 bg-white">
                    <h5 class="modal-title">Düzenle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" onsubmit="return false;">

                        <div class="form-group required mb-3">
                            <label class="form-label">Label</label>
                            <input type="text" value="" class="form-control input_name" onchange="FormElements.setAttr('name', this.value)" required />
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Required</label>
                            <select class="form-control input_required" onchange="FormElements.setRequired(this.value)">
                                <option value="required">Evet</option>
                                <option value="">Hayır</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Helper</label>
                            <input type="text" value="" class="form-control input_helper" onchange="FormElements.helper.setValue(this.value)" />

                        </div>

                        <div class="form-group mb-3">
                            <div class="form-check form-check-inline form-check-right">
                                <label class="form-check-label" for="dc_ri_c">Inline</label>
                                <input type="checkbox" class="form-check-input input_inline" id="dc_ri_c" onchange="FormElements.check_radio.toggleInline(this)">
                            </div>
                        </div>

                        <fieldset class="position-relative">
                            <legend class="text-uppercase font-size-sm font-weight-bold">ITEMS</legend>

                            <table class="table table-bordered table-sm checkbox-items">
                                <thead>
                                <tr>
                                    <th>Text</th>
                                    <th>Value</th>
                                    <th>Checked</th>
                                    <th width="1" class="text-center p-1 pt-0 pb-0">
                                        <a href="javascript:;" class="btn btn-dark btn-sm btn-icon" onclick="FormElements.check_radio.addItem()" title="Add Item"><i class="icon-plus22"></i></a>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>

                        </fieldset>

                    </form>
                </div>
                <div class="modal-footer pt-3 bg-white">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Kapat</button>
                </div>
            </div>
        </div>
    </div>

    <div id="modal_input_file" class="modal fade">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header pb-3 bg-white">
                    <h5 class="modal-title">Düzenle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" onsubmit="return false;">
                        <div class="form-group required mb-3">
                            <label class="form-label">Label</label>
                            <input type="text" value="" class="form-control input_name" onchange="FormElements.setAttr('name', this.value)" required />
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">File Extension</label>
                            <select class="form-control extension_value" onchange="FormElements.input_file.setAccept(this)" multiple>
                                <option value="jpg">JPG</option>
                                <option value="png">PNG</option>
                                <option value="gif">GIF</option>
                                <option value="pdf">PDF</option>
                                <option value="doc">DOC</option>
                                <option value="docx">DOCX</option>
                                <option value="xls">XLS</option>
                                <option value="xlsx">XLSX</option>
                                <option value="mp4">MP4</option>
                                <option value="webp">WEBP</option>
                                <option value="zip">ZIP</option>
                                <option value="rar">RAR</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Max File Upload</label>
                            <div class="input-group">
                                <input type="number" value="1024" class="form-control input_max" onchange="FormElements.input_file.setMax(this.value)"/>
                                <span class="input-group-append"><span class="input-group-text bytesToSize"></span></span>
                            </div>
                            <span class="help-block text-danger d-block mt-2">Server upload_max_filesize : {{ (int)ini_get("upload_max_filesize")*1024 }} KB</span>

                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Required</label>
                            <select class="form-control input_required" onchange="FormElements.setRequired(this.value)">
                                <option value="required">Evet</option>
                                <option value="">Hayır</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Helper</label>
                            <input type="text" value="" class="form-control input_helper" onchange="FormElements.helper.setValue(this.value)" />

                        </div>
                    </form>
                </div>
                <div class="modal-footer pt-3 bg-white">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Kapat</button>
                </div>
            </div>
        </div>
    </div>

    <div id="modal_html_h" class="modal fade">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header pb-3 bg-white">
                    <h5 class="modal-title">Düzenle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" onsubmit="return false;">

                        <div class="form-group required mb-3">
                            <label class="form-label">Type</label>
                            <select class="form-control input_type" onchange="FormElements.h1.setType(this.value)">
                                <option value="H1">H1</option>
                                <option value="H2">H2</option>
                                <option value="H3">H3</option>
                                <option value="H4">H4</option>
                                <option value="H5">H5</option>
                                <option value="H6">H6</option>
                            </select>
                        </div>


                        <div class="form-group required mb-3">
                            <label class="form-label">Value</label>
                            <input type="text" value="" class="form-control input_value" onchange="FormElements.h1.setValue(this.value)" required />
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Class</label>
                            <input type="text" value="" class="form-control input_class" onchange="FormElements.h1.setClass(this.value)" />

                        </div>
                    </form>
                </div>
                <div class="modal-footer pt-3 bg-white">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Kapat</button>
                </div>
            </div>
        </div>
    </div>

    <div id="modal_html_p" class="modal fade">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header pb-3 bg-white">
                    <h5 class="modal-title">Düzenle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" onsubmit="return false;">

                        <div class="form-group required mb-3">
                            <label class="form-label">Value</label>
                            <input type="text" value="" class="form-control input_value" onchange="FormElements.p.setValue(this.value)" required />
                        </div>

                        <div class="form-group mb-3">
                            <button class="btn btn-light btn-sm form-element-p-bold" onclick="FormElements.p.toggleClass(this, 'font-weight-bold')"><i class="icon-bold2"></i></button>
                            <button class="btn btn-light btn-sm form-element-p-italic" onclick="FormElements.p.toggleClass(this, 'font-italic')"><i class="icon-italic2"></i></button>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Class</label>
                            <input type="text" value="" class="form-control input_class" onchange="FormElements.p.setClass(this.value)" />

                        </div>
                    </form>
                </div>
                <div class="modal-footer pt-3 bg-white">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Kapat</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles') @endsection
@section('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if($('.form-editor').children().length){
                $('.form-editor').removeClass('form-editor-empty');
            }

            var options = {
                sortable:{
                    row:{
                        items:'.row',
                        placeholder: "row",
                        update: function( event, ui ) {
                            FormBuilder.update();
                        }
                    },
                    col:{
                        placeholder: "col",
                        connectWith: ".row",
                        update: function( event, ui ) {
                            FormBuilder.update();
                        }
                    },
                    elements:{
                        placeholder: "form-group",
                        connectWith: ".col",
                        update: function( event, ui ) {
                            FormBuilder.update();
                        },
                        receive: function( event, ui ) {
                            if(ui.helper && $(ui.helper).find('.form-edit-item').length > 0){
                                $(ui.helper).find('.form-edit-item').click();
                            }
                        }
                    }
                },
                draggable:{
                    row:{
                        connectToSortable: ".form-editor",
                        helper: function (event) {
                            return drag_item_helper(FormElements.row.create(event));
                        },
                        stop: function(event, ui){
                            drag_item_stop(event, ui);
                            $(".form-editor .row" ).sortable(options.sortable.col).disableSelection();
                            $(".form-editor .col" ).sortable(options.sortable.elements).disableSelection();
                        }
                    },
                    col:{
                        connectToSortable: ".row",
                        helper: function (event) {
                            return drag_item_helper(FormElements.col.create(event));
                        },
                        stop: function(event, ui){
                            drag_item_stop(event, ui);
                            $(".form-editor .col" ).sortable(options.sortable.elements).disableSelection();
                        }
                    },
                    elements:{
                        connectToSortable: ".col",
                        helper: function (event) {
                            var name = FormElements.uid(true);
                            var html = false;
                            var type = $(event.target).data('element');
                            if(type in FormElements){
                                html = FormElements[type].create(name, name, event.target);
                            }
                            return drag_item_helper(html);
                        },
                        stop: function(event, ui){
                            drag_item_stop(event, ui);
                        }
                    }
                }
            }

            $(".form-editor" ).sortable(options.sortable.row).disableSelection();
            $(".form-editor .row").sortable(options.sortable.col).disableSelection();
            $(".form-editor .col").sortable(options.sortable.elements).disableSelection();

            $( "#form-builder-tools .draggable-row").draggable(options.draggable.row).disableSelection();
            $( "#form-builder-tools .draggable-col").draggable(options.draggable.col).disableSelection();
            $( "#form-builder-tools .draggable-element").draggable(options.draggable.elements).disableSelection();

        });


        var FormElements = {
            form_group:null,
            element:null,
            uid:function (is_name) {
                if(is_name){
                    for(var i = 1; i < 1000; i++){
                        if($('[name="Name '+i+'"]').length == 0){
                            return "Name " + i;
                        }
                    }
                }else{
                    return Panel.uid();
                }

            },
            row:{
                create:function (event) {
                    var col = FormElements.col.create(null);
                    return '<div class="row">'+col+'<a href="javascript:;" class="text-danger form-row-remove" title="Remove Row" onclick="FormBuilder.remove(this, \'.row\')"><i class="bx bx-trash"></i> </a></div>';
                },
            },
            col:{
                create:function (event) {
                    return '<div class="col"><a href="javascript:;" class="text-danger form-col-remove" onclick="FormBuilder.remove(this, \'.col\')" title="Remove Col"><i class="bx bx-trash"></i> </a></div>';
                },
            },
            input:{
                create:function (title, name) {
                    var id      = FormElements.uid();
                    var label   = FormElements.label.create(id, title);
                    var input   = '<input type="text" name="'+name+'" id="'+id+'" class="form-control form-element" value="" />';
                    var helper  = FormElements.helper.create();
                    var toolbar = FormBuilder.toolbar('input');
                    return '<div class="form-group" data-type="input" data-content="text">'+ label + input + helper + toolbar + '</div>'
                },
                edit:function (item) {
                    FormElements.form_group = $(item).closest('.form-group');
                    FormElements.element = $(FormElements.form_group).find('.form-element');

                    $('.input_type').val(FormElements.getType());
                    $('.input_name').val(FormElements.getAttr('name'));
                    $('.input_required').val(FormElements.getAttr('required'));
                    $('.input_helper').val(FormElements.helper.getValue());

                    $('#modal_input').modal('show');
                },
            },
            input_file:{
                create:function (title, name) {
                    var id      = FormElements.uid();
                    var label   = '<label for="'+id+'" class="form-label">'+title+'</label>';
                    var input   = '<input type="file" name="'+name+'" id="'+id+'" class="form-control form-element" accept=".jpg,.png,.gif" data-mimes="jpg,png,gif" max="1024" />';
                    var helper  = FormElements.helper.create();
                    var toolbar = FormBuilder.toolbar('input_file');
                    return '<div class="form-group" data-type="input_file" data-content="FILE">' + label + input + helper + toolbar + '</div>'
                },

                edit:function (item) {
                    FormElements.form_group = $(item).closest('.form-group');
                    FormElements.element = $(FormElements.form_group).find('.form-element');

                    $('.input_name').val(FormElements.getAttr('name'));
                    $('.input_required').val(FormElements.getAttr('required'));
                    $('.extension_value').val(FormElements.getAttr('data-mimes').split(','));
                    $('.input_max').val(FormElements.getAttr('max') ? FormElements.getAttr('max') : 1024);

                    $('.bytesToSize').html(this.formatBytes($('.input_max').val() * 1024));

                    $('.input_helper').val(FormElements.helper.getValue());

                    $('#modal_input_file').modal('show');
                },
                setAccept:function (elem) {
                    var accept = [];
                    var mimes = $(elem).val();
                    $.each(mimes, function (i, item) {
                        accept.push('.' + item);
                    })
                    $(FormElements.element).attr('accept', accept.join(','));
                    $(FormElements.element).attr('data-mimes', mimes.join(','));
                    FormBuilder.update();
                },
                setMax:function (value) {
                    $(FormElements.element).attr('max', value);
                    $('.bytesToSize').html(this.formatBytes($('.input_max').val() * 1024));
                    FormBuilder.update();
                },
                formatBytes:function (bytes, decimals = 3) {
                    if (bytes === 0) return '0 Bytes';

                    const k = 1024;
                    const dm = decimals < 0 ? 0 : decimals;
                    const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];

                    const i = Math.floor(Math.log(bytes) / Math.log(k));

                    return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
                }
            },
            textarea:{
                create:function (title, name) {
                    var id      = FormElements.uid();
                    var label   = FormElements.label.create(id, title);

                    var input = '<textarea name="'+name+'" class="form-control form-element" rows="3"></textarea>';
                    var helper = FormElements.helper.create();
                    var toolbar = FormBuilder.toolbar('textarea');
                    return '<div class="form-group" data-type="textarea" data-content="TEXTAREA">'+ label + input + helper + toolbar + '</div>'
                },
                edit:function (item) {

                    FormElements.form_group = $(item).closest('.form-group');
                    FormElements.element = $(FormElements.form_group).find('.form-element');

                    $('.input_name').val(FormElements.getAttr('name'));
                    $('.input_required').val(FormElements.getAttr('required'));
                    $('.input_rows').val(FormElements.getAttr('rows'));
                    $('.input_helper').val(FormElements.helper.getValue());

                    $('#modal_textarea').modal('show');
                },
            },
            dropdown:{
                create:function (title, name) {
                    var options = '<option value="">@lang('Selected')</option>';
                    var id      = FormElements.uid();
                    var label   = FormElements.label.create(id, title);
                    var input   = '<select name="'+name+'" class="form-control form-element">'+options+'</select>';
                    var helper  = FormElements.helper.create();
                    var toolbar = FormBuilder.toolbar('dropdown');
                    return '<div class="form-group" data-type="dropdown" data-content="dropdown">'+ label + input + helper + toolbar + '</div>'
                },
                edit:function (item) {
                    FormElements.form_group = $(item).closest('.form-group');
                    FormElements.element = $(FormElements.form_group).find('.form-element');

                    $('.input_name').val(FormElements.getAttr('name'));
                    $('.input_required').val(FormElements.getAttr('required'));
                    $('.input_helper').val(FormElements.helper.getValue());

                    var options = '';

                    $(FormElements.element).find('option').each(function (index, option) {
                        var t = $(option).html();
                        var v = $(option).attr('value');
                        if(t != '@lang('Selected')'){
                            options += FormElements.dropdown.addOption(t,v);
                        }
                    });
                    $('.dropdown-option-items tbody').html(options);

                    $('#modal_dropdown').modal('show');
                },
                addOption:function (t, v) {
                    var count = $(FormElements.element).find('option').length;

                    var text = t == undefined ?  'Option' + count : t;
                    var value = v == undefined ?  'Value' + count : v;

                    var html = '<tr>\n' +
                        '    <td class="p-1">\n' +
                        '        <input type="text" value="'+text+'" class="form-control option-text" placeholder="Option Text" onchange="FormElements.dropdown.updateOptions()">\n' +
                        '    </td>\n' +
                        '    <td class="p-1">\n' +
                        '        <input type="text" value="'+value+'" class="form-control option-value" placeholder="Option Value" onchange="FormElements.dropdown.updateOptions()">\n' +
                        '    </td>\n' +
                        '    <td class="text-center p-1 pt-0 pb-0">\n' +
                        '        <a href="javascript:;" class="btn btn-danger btn-sm btn-icon" onclick="$(this).closest(\'tr\').remove(); FormElements.dropdown.updateOptions()" title="Remove Element"><i class="bx bx-trash"></i></a>\n' +
                        '    </td>\n' +
                        '</tr>';

                    if(t != undefined){
                        return html;
                    }

                    $('.dropdown-option-items tbody').append(html);
                    FormElements.dropdown.updateOptions();

                },
                updateOptions:function () {

                    var html = '<option value="">@lang('Selected')</option>';
                    $('.dropdown-option-items tbody tr').each(function () {
                        var value = $(this).find('.option-value').val();
                        var text = $(this).find('.option-text').val();
                        html += '<option value="'+value+'">'+text+'</option>';
                    });

                    $(FormElements.element).html(html);

                    FormBuilder.update();
                }
            },
            dropdown_country:{
                create:function (title, name) {
                    var options = '<option value="">@lang('Selected')</option>';
                    @foreach(getCountry() as $value => $name)
                        options+= '<option value="{{ $value }}">{{ $name }}</option>';
                    @endforeach
                    var id      = FormElements.uid();
                    var label   = FormElements.label.create(id, title);
                    var input   = '<select name="'+name+'" class="form-control form-element">'+options+'</select>';
                    var helper  = FormElements.helper.create();
                    var toolbar = FormBuilder.toolbar('dropdown_country');
                    return '<div class="form-group" data-type="dropdown_country" data-content="DROPDOWN COUNTRY">'+ label + input + helper + toolbar + '</div>'
                },
                edit:function (item) {
                    FormElements.form_group = $(item).closest('.form-group');
                    FormElements.element = $(FormElements.form_group).find('.form-element');

                    $('.input_name').val(FormElements.getAttr('name'));
                    $('.input_required').val(FormElements.getAttr('required'));
                    $('.input_helper').val(FormElements.helper.getValue());

                    $('#modal_dropdown_country').modal('show');
                },
            },
            dropdown_city:{
                create:function (title, name) {
                    var options = '<option value="">@lang('Selected')</option>';
                    var id      = FormElements.uid();
                    var label   = FormElements.label.create(id, title);
                    var input   = '<select name="'+name+'" class="form-control form-element" data-target="">'+options+'</select>';
                    var helper  = FormElements.helper.create();
                    var toolbar = FormBuilder.toolbar('dropdown_city');
                    return '<div class="form-group" data-type="dropdown_city" data-content="DROPDOWN CITY - TARGET COUNTRY [NULL]">'+ label + input + helper + toolbar + '</div>'
                },
                target:function (e, t) {

                    var element = e == null ? FormElements.element : e;
                    var form_group = e == null ? FormElements.form_group : $(e).closest('.form-group');

                    $(element).data('target', t);
                    $(element).attr('data-target', t);
                    $(form_group).data('content', 'DROPDOWN CITY - TARGET COUNTRY [' + t + ']');
                    $(form_group).attr('data-content', 'DROPDOWN CITY - TARGET COUNTRY [' + t + ']');

                    FormBuilder.update();
                },
                edit:function (item) {
                    FormElements.form_group = $(item).closest('.form-group');
                    FormElements.element = $(FormElements.form_group).find('.form-element');

                    $('.input_name').val(FormElements.getAttr('name'));
                    $('.input_required').val(FormElements.getAttr('required'));
                    $('.input_helper').val(FormElements.helper.getValue());

                    var options = '<option value="">@lang('Selected')</option>';

                    $('[data-type="dropdown_country"]').each(function () {
                        var value = $(this).closest('.form-group').find('select').attr('name');
                        var title = $(this).closest('.form-group').find('label').html();
                        var selected = $(FormElements.element).data('target') == value ? 'selected' : '';
                        options += '<option value="'+value+'" '+selected+'>'+title+'</option>';
                    })
                    $('.target_country').html(options);

                    $('#modal_dropdown_city').modal('show');
                },
            },
            check_radio:{
                template:function (type, name, label, value, checked, inline) {
                    var id = FormElements.uid();
                    return '<div class="form-check '+inline+'">\n' +
                        '  <input class="form-check-input" type="'+type+'" name="'+name+'" value="'+value+'" id="'+id+'" '+checked+'>\n' +
                        '  <label class="form-check-label" for="'+id+'">'+label+'</label>\n' +
                        '</div>'
                },
                create:function (title, name, target) {
                    var id      = FormElements.uid();
                    var label   = FormElements.label.create(id, title, 'd-block');
                    var helper  = FormElements.helper.create();
                    var toolbar = FormBuilder.toolbar('check_radio');
                    var type = $(target).data('type');
                    var item_label = type == 'checkbox' ? 'Checkbox 1' : 'Radio 1';

                    var items = FormElements.check_radio.template(type, name, item_label, 'Value 1', '', '');
                    return '<div class="form-group" data-type="'+type+'" data-content="'+type+'">'+ label + items + helper + toolbar + '</div>'
                },
                edit:function (item) {
                    FormElements.form_group = $(item).closest('.form-group');
                    FormElements.element = $(FormElements.form_group).find('.form-check-input');



                    $('.input_name').val(FormElements.getAttr('name'));
                    $('.input_required').val(FormElements.getAttr('required'));
                    $('.input_helper').val(FormElements.helper.getValue());

                    var items = '';
                    $(FormElements.form_group).find('.form-check').each(function (i, item) {
                        var t = $(item).find('.form-check-label').html();
                        var v = $(item).find('.form-check-input').val();
                        var c = $(item).find('.form-check-input:checked').length ? 'checked' : '';
                        items += FormElements.check_radio.addItem(t, v, c);
                    });

                    $('.input_inline').attr('checked', false);
                    $('.input_inline').prop('checked', false);
                    if($(FormElements.form_group).find('.form-check-inline').length){
                        $('.input_inline').attr('checked', true);
                        $('.input_inline').prop('checked', true);
                    }

                    $('.checkbox-items tbody').html(items);

                    $('#modal_checkbox').modal('show');
                },
                toggleInline:function (element) {
                    $(FormElements.form_group).find('.form-check').removeClass('form-check-inline');
                    if($(element).is(':checked')){
                        $(FormElements.form_group).find('.form-check').addClass('form-check-inline');
                    }

                    FormBuilder.update();
                },
                update:function () {
                    var html = '';

                    var type = FormElements.getType();
                    var name = FormElements.label.getValue();
                    var inline = $(FormElements.form_group).find('.form-check-inline').length ? 'form-check-inline' : '';

                    $('.checkbox-items tbody tr').each(function (i, item) {
                        var value = $(item).find('.option-value').val();
                        var text = $(item).find('.option-text').val();
                        var checked = $(item).find('.option-checked:checked').length ? 'checked' : '';

                        html += FormElements.check_radio.template(type, name, text, value, checked, inline );
                    })

                    $(FormElements.form_group).find('.form-check').remove();
                    $(html).insertAfter($(FormElements.form_group).find('label'));

                    FormBuilder.update();
                },
                addItem:function (t, v, c) {

                    var count = $(FormElements.form_group).find('.form-check-input').length + 1;
                    var type = FormElements.getType();
                    var label = type == 'checkbox' ? 'Checkbox ' : 'Radio ';
                    var text = t == undefined ?  label + count : t;
                    var value = v == undefined ?  'Value' + count : v;
                    var checked = c == undefined ?  '' : c;

                    var html = '<tr>\n' +
                        '    <td class="p-1">\n' +
                        '        <input type="text" value="'+text+'" class="form-control option-text" placeholder="Item Text" onchange="FormElements.check_radio.update()">\n' +
                        '    </td>\n' +
                        '    <td class="p-1">\n' +
                        '        <input type="text" value="'+value+'" class="form-control option-value" placeholder="Item Value" onchange="FormElements.check_radio.update()">\n' +
                        '    </td>\n' +
                        '    <td class="p-1 text-center">\n' +
                        '        <input type="checkbox" value="checked" class="option-checked" onchange="FormElements.check_radio.update()" '+checked+'>\n' +
                        '    </td>\n' +
                        '    <td class="text-center p-1 pt-0 pb-0">\n' +
                        '        <a href="javascript:;" class="btn btn-danger btn-sm btn-icon" onclick="$(this).closest(\'tr\').remove(); FormElements.check_radio.update()" title="Remove Element"><i class="bx bx-trash"></i></a>\n' +
                        '    </td>\n' +
                        '</tr>';

                    if(t != undefined){
                        return html;
                    }

                    $('.checkbox-items tbody').append(html);
                    FormElements.check_radio.update();
                }
            },
            helper:{
                create:function () {
                    return '<span class="help-block text-muted"></span>';
                },
                has:function () {
                    return $(FormElements.form_group).find('.help-block').length > 0;
                },
                get:function () {
                    return  $(FormElements.form_group).find('.help-block')
                },
                getValue:function () {
                    return $(FormElements.form_group).find('.help-block').html();
                },
                setValue:function (value) {
                    if(this.has()){
                        $(FormElements.form_group).find('.help-block').html(value);
                    }
                    FormBuilder.update();
                }
            },
            label: {
                create:function (id, title, classes) {
                    var c = '';
                    if(classes){
                        c = 'class="form-label '+classes+'"'
                    }
                    return '<label for="'+id+'" '+c+'>'+title+'</label>';
                },
                getValue:function () {
                    return $(FormElements.form_group).find('>label').html();
                },
                setAttr:function (attrName, value) {
                    $(FormElements.form_group).find('>label').attr(attrName, value);
                },
                change:function (title) {
                    $(FormElements.form_group).find('>label').html(title);
                }
            },
            p:{
                create:function (title, name) {
                    var element = '<p class="form-element html-element">'+name+'</p>';
                    var toolbar = FormBuilder.toolbar('p');
                    return '<div class="form-group" data-type="html" data-content="PARAGRAPH">'+element + toolbar+'</div>';
                },
                toggleClass:function (elem, value) {
                    $(elem).toggleClass('btn-light btn-dark');
                    $(FormElements.element).toggleClass(value);
                    FormBuilder.update();
                },
                setClass:function (value) {
                    FormElements.setAttr('class', 'form-element html-element ' + value.trim());
                    FormBuilder.update();
                },
                setValue:function (val) {
                    $(FormElements.element).html(val);
                    FormBuilder.update();
                },
                edit:function (item) {
                    FormElements.form_group = $(item).closest('.form-group');
                    FormElements.element = $(FormElements.form_group).find('.form-element');

                    $('.input_value').val(FormElements.element.html());

                    var classes = $(FormElements.element).clone().removeClass('form-element html-element font-weight-bold font-italic').attr('class');

                    $('.input_class').val(classes);

                    if($(FormElements.element).hasClass('font-weight-bold')){
                        $('.form-element-p-bold').removeClass('btn-light').addClass('btn-dark');
                    }

                    if($(FormElements.element).hasClass('font-italic')){
                        $('.form-element-p-italic').removeClass('btn-light').addClass('btn-dark');
                    }

                    $('#modal_html_p').modal('show');
                }
            },
            h1:{
                create:function (title, name) {
                    var element = '<h1 class="form-element html-element">'+name+'</h1>';
                    var toolbar = FormBuilder.toolbar('h1');
                    return '<div class="form-group" data-type="html" data-content="H1">'+element + toolbar+'</div>';
                },
                setType:function (type) {
                    $(FormElements.form_group).attr('data-content', type);
                    $(FormElements.form_group).data('content', type);
                    var value = $(FormElements.element).html();
                    var classes = $(FormElements.element).attr('class');
                    var newElement  = $('<'+type+' class="'+classes+'"/>').addClass().html(value);
                    $(FormElements.element).replaceWith(newElement);
                    FormElements.element = newElement;
                    FormBuilder.update();
                },
                setValue:function (val) {
                    $(FormElements.element).html(val);
                    FormBuilder.update();
                },
                setClass:function (value) {
                    FormElements.setAttr('class', 'form-element html-element ' + value.trim());
                    FormBuilder.update();
                },
                edit:function (item) {
                    FormElements.form_group = $(item).closest('.form-group');
                    FormElements.element = $(FormElements.form_group).find('.form-element');
                    $('.input_type').val(FormElements.getType());
                    $('.input_value').val(FormElements.element.html());
                    $('.input_class').val(FormElements.getAttr('class').replace('form-element html-element', '').trim());

                    $('#modal_html_h').modal('show');
                }
            },
            hr:{
                create:function (name) {
                    var element = '<hr>';
                    var toolbar = FormBuilder.toolbar();
                    return '<div class="form-group" data-type="html" data-content="HR">' + element + toolbar +'</div>';
                }
            },
            getType:function () {
                return $(FormElements.form_group).data('content');
            },
            getAttr:function(attrName){
                return $(FormElements.element).attr(attrName)
            },
            setRequired:function (value) {
                if(value == 'required'){
                    $(FormElements.form_group).find('>label').addClass('required');
                    $(FormElements.element).attr('required', true);
                }else{
                    $(FormElements.form_group).find('>label').removeClass('required');
                    $(FormElements.element).attr('required', false);
                }

                FormBuilder.update();
            },
            setAttr:function (attrName, value) {
                if(attrName == 'type'){
                    $(FormElements.form_group).data('content', value);
                    $(FormElements.form_group).attr('data-content', value);
                }

                if(attrName == 'name'){
                    if(value == ""){
                        return;
                    }

                    var oldName = $(FormElements.element).attr('name');
                    $('[data-target="'+oldName+'"]').each(function (i, element) {
                        FormElements.dropdown_city.target(element, value);
                    })

                    FormElements.label.change(value);
                }

                $(FormElements.element).attr(attrName, value);


                FormBuilder.update();
            },

        }

        var FormBuilder = {

            toolbar:function (edit) {
                if(edit == undefined || edit == ''){
                    return '<div class="form-group-toolbar">\n' +
                        '    <div class="list-icons">\n' +
                        '        <a href="javascript:;" class="list-icons-item text-danger" onclick="FormBuilder.remove(this, \'.form-group\')" title="Remove Element"><i class="bx bx-trash"></i></a>\n' +
                        '    </div>\n' +
                        '</div>';
                }

                return '<div class="form-group-toolbar">\n' +
                    '    <div class="list-icons">\n' +
                    '        <a href="javascript:;" class="list-icons-item form-edit-item text-primary" onclick="FormElements.'+edit+'.edit(this)" title="Edit Element"><i class="bx bx-pencil"></i></a>\n' +
                    '        <a href="javascript:;" class="list-icons-item text-danger" onclick="FormBuilder.remove(this, \'.form-group\')" title="Remove Element"><i class="bx bx-trash"></i></a>\n' +
                    '    </div>\n' +
                    '</div>';
            },
            remove:function (element, target) {
                $(element).closest(target).remove();
                this.update();
            },
            update:function () {

                //Editor Boostrap 5
                var html = $('.form-editor').clone();

                $(html).find('.form-floating .form-element').each(function () {
                    $(this).attr('placeholder', null);
                    $(this).prop('placeholder', null);
                    $(this).prependTo($(this).closest('.form-floating'))
                })

                $(html).find('.form-group .help-block').addClass('form-text').removeClass('help-block text-muted');

                $(html).find('.form-group-toolbar, .form-col-remove, .form-row-remove').remove();
                $(html).find('*').removeClass('ui-draggable-dragging ui-sortable-handle ui-sortable form-element html-element');
                $(html).find('*').removeAttr('style');
                $(html).find('.form-group').removeAttr('data-type');
                $(html).find('.form-group').removeAttr('data-content');

                $(html).find('.form-floating').removeClass('form-group');

                $(html).find('select.form-control').addClass('form-select').removeClass('form-control');

                $(html).find('[required]').closest('div').addClass('required');

                this.getValidations(html);


                // Checkbox name array
                $(html).find('[type="checkbox"]').each(function () {
                    $(this).attr('name',  $(this).attr('name') + '[]')
                })

                $('[name="settings[form_body]"]').val($(html).html());



                //$('[name="settings[form_required]"]').val(requireds.join('||'));

                //Editor Editable
                var editor_html = $('.form-editor').clone();
                $(editor_html).find('*').removeClass('ui-draggable-dragging ui-sortable-handle ui-sortable');
                $(editor_html).find('*').removeAttr('style');

                $('[name="settings[form_body_edit]"]').val($(editor_html).html());
            },
            getValidations:function (html) {
                var fields = [];
                var requireds = [];

                $(html).find('[required], [data-mimes]').each(function () {
                    var key = $(this).attr('name');
                    var required = false;
                    var mimes = false;
                    if($(this).attr('required')){
                        required = true;
                    }

                    if($(this).attr('data-mimes')){
                        var max = $(this).attr('max') ? $(this).attr('max') : 1024;
                        mimes = $(this).attr('data-mimes') + '|max:' + max;
                    }

                    if(!fields[key]){
                        var validation = [];
                        if(required){
                            validation.push('required');
                        }
                        if(mimes){
                            validation.push('mimes:' + mimes);
                        }
                        requireds.push(key + '=' + validation.join('|'));
                    }

                    fields.push(fields);
                });

                $('[name="settings[form_required]"]').html(requireds.join('||'));

            }
        }

        function drag_item_helper(elem) {
            return $(elem).css({
                'border': '1px dashed #ddd',
                'min-height': $('#form-builder-tools .nav-item').height(),
                'min-width': $('#form-builder-tools .nav-item').width(),
                'max-width': $('#form-builder-tools .nav-item').width()
            });
        }
        function drag_item_stop(event, ui) {
            $(ui.helper).removeAttr('style');

            if($('.form-editor').children().length){
                $('.form-editor').removeClass('form-editor-empty');
            }
        }


    </script>
@endsection
