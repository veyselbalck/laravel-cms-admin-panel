@extends('panel.layouts.default')

@php
    $breadcrumb = !empty($model->content_datas["breadcrumb"]) ? $model->content_datas["breadcrumb"] : "";
    $cover2 = !empty($model->content_datas["cover2"]) ? $model->content_datas["cover2"] : "";
    $product_code = !empty($model->content_datas["product_code"]) ? $model->content_datas["product_code"] : "";
    $video = !empty($model->content_datas["video"]) ? $model->content_datas["video"] : "";
    $application_video = !empty($model->content_datas["application_video"]) ? $model->content_datas["application_video"] : "";
@endphp

@section('content')
    <form action="{{ route("products.update", $model->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="w-full text-end" style="margin-top: -45px;">
            <button type="submit" class="btn btn-warning"><i class="bx bxs-save"></i> Kaydet</button>
        </div>
        <div id="wizard-checkout" class="bs-stepper wizard-icons wizard-icons-example mt-2">
            <div class="bs-stepper-header m-auto border-0">
                <div class="step" data-target="#step-general">
                    <button type="button" class="step-trigger">
                      <span class="bs-stepper-icon">
                        <svg viewBox="0 0 58 54">
                          <use xlink:href="/panel/assets/svg/icons/wizard-checkout-confirmation.svg#wizardConfirm"></use>
                        </svg>
                      </span>
                        <span class="bs-stepper-label">Genel Bilgiler</span>
                    </button>
                </div>
                <div class="line">
                    <i class="bx bx-chevron-right"></i>
                </div>
                <div class="step" data-target="#step-media">
                    <button type="button" class="step-trigger">
                      <span class="bs-stepper-icon">
                        <svg viewBox="0 0 58 54"><use xlink:href="/panel/assets/svg/icons/form-wizard-social-link.svg#wizardSocialLink"></use></svg>
                      </span>
                        <span class="bs-stepper-label">Medya</span>
                    </button>
                </div>
            </div>
            <div class="bs-stepper-content border-top">

                <div id="wizard-checkout-form">
                    <div id="step-general" class="content">
                        <div class="row">

                            <div class="col-lg-9 col-md-12">
                                <div class="list-group mb-3">
                                    <div class="list-group-item p-4">
                                        <div class="card-body">
                                            <div class="form-group mb-3">
                                                <label for="name" class="form-label text-danger">Lokasyon Adı *</label>
                                                <input class="form-control" type="text" required id="name" name="name" value="{{ old("name", $model->title) }}"/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="list-group-item p-4">
                                        <div class="card-body">
                                            <div class="card-header">
                                                <ul class="nav nav-tabs tabs-line" role="tablist">
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
                                            </div>

                                            <div class="tab-content px-0 pb-0">
                                                @foreach(getLanguagesByCodeId() as $code => $lang)
                                                    @php
                                                        $slug = !empty($descriptions[$lang]['slug']) ? $descriptions[$lang]['slug'] : '';
                                                        $description = !empty($descriptions[$lang]['description']) ? $descriptions[$lang]['description'] : '';
                                                        $name = !empty($descriptions[$lang]['name']) ? $descriptions[$lang]['name'] : '';
                                                        $meta_title = !empty($descriptions[$lang]['meta_title']) ? $descriptions[$lang]['meta_title'] : '';
                                                        $meta_description = !empty($descriptions[$lang]['meta_description']) ? $descriptions[$lang]['meta_description'] : '';
                                                        $meta_keyword = !empty($descriptions[$lang]['meta_keyword']) ? $descriptions[$lang]['meta_keyword'] : '';
                                                        $catalog = !empty($model->content_datas[$lang]['catalog']) ? $model->content_datas[$lang]['catalog'] : '';
                                                        $catalog_icon = "";
                                                        if($catalog) {
                                                            $ex = explode(".", $catalog);
                                                            $catalog_icon = "ico-".$ex[count($ex) - 1];
                                                        }


                                                        $technical      = !empty($model->content_datas['contents'][$lang]['technical']) ? $model->content_datas['contents'][$lang]['technical'] : '';
                                                        $optional          = !empty($model->content_datas['contents'][$lang]['optional']) ? $model->content_datas['contents'][$lang]['optional'] : '';
                                                    @endphp
                                                    <div class="tab-pane fade @if($loop->first) show active @endif" id="tab-content-{{$code}}" role="tabpanel">
                                                        <div class="form-group mb-3">
                                                            <label for="name" class="form-label">Sayfa Başlığı</label>
                                                            <div class="input-group">
                                                                <input class="form-control" type="text" name="descriptions[{{$lang}}][name]"
                                                                       id="descriptions_{{$lang}}name"
                                                                       value="{{ old("descriptions.".$lang.".name", $name) }}"/>
                                                                <button type="button" class="btn btn-dark"
                                                                        onclick="$('#descriptions_{{$lang}}name').val($('#name').val())">Doldur</button>
                                                            </div>
                                                        </div>
                                                        <div class="row row-cols-md-2">

                                                            <div class="form-group mb-3">
                                                                <label for="name" class="form-label">Meta Başlığı</label>
                                                                <div class="input-group">
                                                                    <input class="form-control" type="text" name="descriptions[{{$lang}}][meta_title]"
                                                                           id="descriptions_{{$lang}}meta_title"
                                                                           value="{{ old("descriptions.".$lang.".meta_title", $meta_title) }}"/>
                                                                    <button type="button" class="btn btn-dark"
                                                                            onclick="$('#descriptions_{{$lang}}meta_title').val($('#descriptions_{{$lang}}name').val())">Doldur</button>
                                                                </div>
                                                            </div>

                                                            <div class="form-group mb-3">
                                                                <label for="name" class="form-label">Slug/Link</label>
                                                                <div class="input-group">
                                                                    <input class="form-control" type="text" name="descriptions[{{$lang}}][slug]"
                                                                           id="descriptions_{{$lang}}slug"
                                                                           value="{{ old("descriptions.".$lang.".slug", $slug) }}"/>
                                                                    <button type="button" class="btn btn-dark"
                                                                            onclick="$('#descriptions_{{$lang}}slug').val(slugify($('#descriptions_{{$lang}}name').val()))">Oluştur</button>
                                                                </div>
                                                            </div>
                                                            <div class="form-group mb-3">
                                                                <label class="form-label">Meta Açıklama</label>
                                                                <textarea class="form-control" rows="3"
                                                                          name="descriptions[{{$lang}}][meta_description]"
                                                                          id="descriptions_{{$lang}}meta_description">{{ old("descriptions.".$lang.".meta_description", $meta_description) }}</textarea>
                                                            </div>
                                                            <div class="form-group mb-3">
                                                                <label class="form-label">Meta Kelimeleri</label>
                                                                <textarea class="form-control" rows="3"
                                                                          name="descriptions[{{$lang}}][meta_keyword]"
                                                                          id="descriptions_{{$lang}}meta_keyword">{{ old("descriptions.".$lang.".meta_keyword", $meta_keyword) }}</textarea>
                                                            </div>

                                                        </div>

                                                        <div class="form-group">
                                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                                <label for="descriptions_{{ $lang }}_description" class="form-label">Ana Başlık</label>
                                                                <button type="button" class="btn btn-sm btn-linkedin" onclick="ModuleModal()"><i class="bx bx-list-ol"></i> Modüller</button>
                                                            </div>
                                                            <textarea name="descriptions[{{ $lang }}][description]" id="descriptions_{{ $lang }}_description" class="form-control editor-ck"
                                                                      data-height="300">{{ old('descriptions.'.$lang.'.description', $description) }}</textarea>
                                                        </div>



                                                        <hr class="mx-n3 mt-3">
                                                        <div class="form-group mb-3">
                                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                                <label for="contents_{{ $lang }}_optional" class="form-label">Alt Başlık</label>
                                                            </div>
                                                            <textarea name="datas[contents][{{$lang}}][optional]"
                                                                      id="contents_{{ $lang }}_optional"
                                                                      class="form-control editor-ck"
                                                                      data-height="250">{{ old('datas.contents.'.$lang.'.optional', $optional) }}</textarea>
                                                        </div>
                                                        <hr class="mx-n3 mt-3">
                                                        <div class="form-group mb-3">
                                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                                <label for="contents_{{ $lang }}_technical" class="form-label">Açıklama Metni</label>
                                                            </div>
                                                            <textarea name="datas[contents][{{$lang}}][technical]"
                                                                      id="contents_{{ $lang }}_technical"
                                                                      class="form-control editor-ck"
                                                                      data-height="250">{{ old('datas.contents.'.$lang.'.technical', $technical) }}</textarea>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-12">
                                <div class="border rounded p-3 mb-3">
                                    <h6>Özellikler</h6>

                                   {{-- <div class="form-group mb-3">
                                        <label for="product_code" class="form-label">Ürün Kodu</label>
                                        <input class="form-control" type="text" id="product_code" name="datas[product_code]" value="{{ old("datas.product_code", $product_code) }}"/>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="name" class="form-label">Sıra Numarası</label>
                                        <input class="form-control" type="text" id="sort_order" name="sort_order" value="{{ old("sort_order", $model->sort_order) }}"/>
                                    </div>--}}

                                    <div class="form-group mb-3">
                                        <label for="name" class="form-label text-danger">Şablon Tipi *</label>
                                        <select class="select2 form-control" name="template" required>
                                            @foreach(templates("product") as $key => $value)
                                                <option value="{{$key}}" @if(old("template", $model->template) == $key) selected @endif>{{$value}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="name" class="form-label text-danger">İçerik Tipi *</label>
                                        <select class="select2 form-control" name="content_type" required>
                                            @foreach(contentTypes('product') as $key => $value)
                                                <option value="{{$key}}" @if(old("content_type", $model->content_type) == $key) selected @endif>{{$value}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="name" class="form-label">Durumu</label>
                                        <select class="select2 form-control" name="status">
                                            <option value="1" @if(old("status", $model->status) == 1) selected @endif>Aktif</option>
                                            <option value="0" @if(old("status", $model->status) == 0) selected @endif>Pasif</option>
                                        </select>
                                    </div>
                                    <hr class="mx-n3">

                                    <div class="my-4">
                                        <h6>Kategori</h6>
                                        <div class="form-group mb-3">
                                            <select class="select2 form-control" name="parent_id">
                                                @foreach(contents('products') as $item)
                                                    <option value="{{$item->id}}" @if(old("parent_id", $model->parent_id) == $item->id) selected @endif>{{$item->title}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <hr class="mx-n3">

                                    {{--<div class="form-group mb-3">
                                        <label for="video" class="form-label">Youtube Link</label>
                                        <input class="form-control" type="text" id="video" name="datas[video]" value="{{ old("datas.video", $video) }}"/>
                                    </div>--}}

                                    <hr class="mx-n3">
                                    {{--<h6>Breadcrumb Görsel</h6>
                                    <div class="form-group">
                                        <a data-input="thumbBreadcrumb" data-preview="BreadcrumbHolder" class="lfm-image">
                                            <img src="{{ old("datas.breadcrumb", $breadcrumb ? $breadcrumb : "/panel/img/placeholder.png") }}" class="d-block rounded mb-3 cursor-pointer" width="100%" id="BreadcrumbHolder" />
                                        </a>
                                        <input id="thumbBreadcrumb" class="form-control mb-1" onchange="lfmInput($(this))" type="hidden"
                                               name="datas[breadcrumb]" readonly
                                               value="{{ old("datas.breadcrumb", $breadcrumb) }}">
                                        <button type="button" class="btn btn-sm btn-danger img-trash mt-1 mb-1 @if($breadcrumb == "") d-none @endif"
                                                data-id="thumbBreadcrumb"
                                                data-preview="BreadcrumbHolder"><i class="bx bx-x"></i> Sil</button>
                                    </div>--}}

                                    <hr class="mx-n3">
                                    <h6>Kapak Görseli</h6>
                                    <div class="form-group">
                                        <a data-input="thumbCover" data-preview="CoverHolder" class="lfm-image">
                                            <img src="{{ old("image", $model->image ? $model->image : "/panel/img/placeholder.png") }}" class="d-block rounded cursor-pointer" width="100%" id="CoverHolder" />
                                        </a>
                                        <input id="thumbCover" class="form-control mb-1" onchange="lfmInput($(this))" type="hidden"
                                               name="image" readonly
                                               value="{{ old("image", $model->image) }}">
                                        <button type="button" class="btn btn-sm btn-danger img-trash mt-1 mb-1 @if($model->image == "" || $model->image == null) d-none @endif"
                                                data-id="thumbCover"
                                                data-preview="CoverHolder"><i class="bx bx-x"></i> Sil</button>
                                    </div>

                                    {{--<hr class="mx-n3 mt-0">
                                    <h6>Kapak Görsel 2</h6>
                                    <div class="form-group">
                                        <a data-input="thumbCover2" data-preview="Cover2Holder" class="lfm-image">
                                            <img src="{{ old("datas.cover2", $cover2 ? $cover2 : "/panel/img/placeholder.png") }}" class="d-block rounded mb-3 cursor-pointer" width="100%" id="Cover2Holder" />
                                        </a>
                                        <input id="thumbCover2" class="form-control mb-1" onchange="lfmInput($(this))" type="hidden"
                                               name="datas[cover2]" readonly
                                               value="{{ old("datas.cover2", $cover2) }}">
                                        <button type="button" class="btn btn-sm btn-danger img-trash mt-1 mb-1 @if($cover2 == "") d-none @endif"
                                                data-id="thumbCover2"
                                                data-preview="Cover2Holder"><i class="bx bx-x"></i> Sil</button>
                                    </div>--}}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="step-media" class="content">

                        <ul class="nav nav-tabs tabs-line pt-2" role="tablist">
                            @foreach(getModelLanguages() as $lang)
                                <li class="nav-item">
                                    <button type="button" class="nav-link @if($loop->first) active @endif" role="tab" data-bs-toggle="tab"
                                            data-bs-target="#tab-content-media-{{$lang->code}}"
                                            aria-controls="tab-content-media-{{$lang->code}}"
                                            aria-selected="true">
                                        {{$lang->name}}
                                    </button>
                                </li>
                            @endforeach
                        </ul>

                        <div class="tab-content px-0 pb-0">
                            @foreach(getLanguagesByCodeId() as $lang_code => $lang)
                                <div class="tab-pane media-tab-pane fade @if($loop->first) show active @endif" id="tab-content-media-{{$lang_code}}" data-language-id="{{ $lang }}" role="tabpanel">

                                    <div class="card-body">
                                        <div class="text-end mt-3 mb-md-n3">
                                            <button type="button" class="btn btn-dark"  onclick="modal_module_add()"><i class="bx bx-plus"></i> Ekle</button>
                                        </div>
                                    </div>

                                    <h5 class="card-header pt-0">Medya</h5>

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
                                                            <input type="hidden" name="datas[items][{{$lang}}][{{$key}}][title]" value="{{$item["title"]}}" data-edit-name="title">
                                                            <input type="hidden" name="datas[items][{{$lang}}][{{$key}}][description]" value="{{$item["title"]}}" data-edit-name="description">
                                                            <input type="hidden" name="datas[items][{{$lang}}][{{$key}}][image]" value="{{$item["image"] ? asset($item["image"]) : ""}}" data-edit-name="image">
                                                            <input type="hidden" name="datas[items][{{$lang}}][{{$key}}][sort_order]" value="{{ !empty($item["sort_order"]) ? $item["sort_order"] : 999 }}" data-edit-name="sort_order">
                                                            <input type="hidden" name="datas[items][{{$lang}}][{{$key}}][file_type]" value="{{ !empty($item["file_type"]) ? $item["file_type"] : 'file' }}" data-edit-name="file_type">
                                                            <input type="hidden" name="datas[items][{{$lang}}][{{$key}}][video_id]" value="{{ !empty($item["video_id"]) ? $item["video_id"] : '' }}" data-edit-name="video_id">
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
                </div>
            </div>
        </div>

    </form>

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

@push("styles")
    <link rel="stylesheet" href="/panel/assets/vendor/css/pages/wizard-ex-checkout.css" />
    <script>
        let modules = '{!! json_encode($modules) !!}'
    </script>
@endpush

@push("scripts")
    <script src="/panel/assets/js/wizard-ex-checkout.js"></script>
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
                        inputs += '<textarea name="datas[items]['+language_id+']['+id+']['+name+']" data-edit-name="'+name+'" class="d-none">'+value+'</textarea>';

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
                        inputs += '<input type="{{ $input_type }}" name="datas[items]['+language_id+']['+id+']['+name+']" value="'+value+'" data-edit-name="'+name+'">';

                        break;
                    default:
                        if(name === "video_id") video_id = value;
                        if(name === "file_type") file_type = value;
                        inputs += '<input type="{{ $input_type }}" name="datas[items]['+language_id+']['+id+']['+name+']" value="'+value+'" data-edit-name="'+name+'">';
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
                            inputs += '<input type="{{ $input_type }}" name="datas[items]['+language_id+']['+id+']['+name+']" value="'+value+'" data-edit-name="'+name+'">';
                            break;
                        default:
                            if(name === "video_id") video_id = value;
                            if(name === "file_type") file_type = value;
                            inputs += '<input type="{{ $input_type }}" name="datas[items]['+language_id+']['+id+']['+name+']" value="'+value+'" data-edit-name="'+name+'">';
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

        function videoDelete() {
            document.getElementById("thumbnailVideo").value = "";
            document.getElementById("videoDeleteButton").remove();
        }

        $('#lfmFile').filemanager('image');
        $('#lfmVideo').filemanager('image');
    </script>
@endpush
