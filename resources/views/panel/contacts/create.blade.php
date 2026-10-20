@extends('panel.layouts.default')

@section('content')
    <div class="row">
        <form action="{{ route("contacts.store") }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="col-lg-8 col-md-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-9 mb-3">
                                <label for="name" class="form-label text-danger">Başlık *</label>
                                <input class="form-control" type="text" required id="name" name="name" value="{{ old("name") }}"/>
                                <small>Panelde gözükecek başlık.</small>
                            </div>
                            <div class="form-group mb-3 col-md-3">
                                <label for="name" class="form-label">Sıra No</label>
                                <input class="form-control" type="number" required id="sort_order" name="sort_order" value="{{ old("sort_order") }}"/>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label class="switch switch-primary">
                                <input type="checkbox" class="switch-input" name="status" value="1" @if(old("status", 1)) checked @endif />
                                <span class="switch-toggle-slider"><span class="switch-on"><i class="bx bx-check"></i></span><span class="switch-off"><i class="bx bx-x"></i></span></span>
                                <span class="switch-label">Aktif mi?</span>
                            </label>
                        </div>
                    </div>
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
                            <div class="tab-pane fade @if($loop->first) show active @endif" id="tab-content-{{$lang_code}}" data-language-id="{{ $lang }}" role="tabpanel">
                                <div class="card-body mb-3">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Başlık</label>
                                        <input type="text" name="settings[translation][{{$lang}}][title]"
                                               id="settings_translation_{{$lang}}_title"
                                               value="{{ old('settings.translation.'.$lang.'.title') }}" class="form-control" />
                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="form-label">Açıklama</label>
                                        <input type="text" name="settings[translation][{{$lang}}][description]" value="{{ old('settings.translation.'.$lang.'.description') }}" class="form-control" />
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-body">

                            <div class="row row-cols-sm-2">
                                <div class="form-group mb-3 col">
                                    <label class="form-label">Adres / Satır 1</label>
                                    <input type="text" name="settings[address1]" id="settings_1" value="{{ old('settings.address1') }}" class="form-control" />
                                </div>

                                <div class="form-group mb-3 col">
                                    <label class="form-label">Adres / Satır 2</label>
                                    <input type="text" name="settings[address2]" id="settings_2" value="{{ old('settings.address2') }}" class="form-control" />
                                </div>
                            </div>

                            <hr class="mb-4" />

                            <div class="row row-cols-sm-2">
                                <div class="form-group mb-3 col">
                                    <label class="form-label">Telefon 1</label>
                                    <input type="text" name="settings[phone1]" id="phone1" value="{{ old('settings.phone1') }}" class="form-control" />
                                </div>

                                <div class="form-group mb-3 col">
                                    <label class="form-label">Telefon 2</label>
                                    <input type="text" name="settings[phone2]" id="phone2" value="{{ old('settings.phone2') }}" class="form-control" />
                                </div>

                                <div class="form-group mb-3 col">
                                    <label class="form-label">Telefon 3</label>
                                    <input type="text" name="settings[phone3]" id="phone3" value="{{ old('settings.phone3') }}" class="form-control" />
                                </div>

                                <div class="form-group mb-3 col">
                                    <label class="form-label">Telefon 4</label>
                                    <input type="text" name="settings[phone4]" id="phone4" value="{{ old('settings.phone4') }}" class="form-control" />
                                </div>
                            </div>

                            <hr class="mb-4" />

                            <div class="row row-cols-sm-2">
                                <div class="form-group mb-3 col">
                                    <label class="form-label">Faks</label>
                                    <input type="text" name="settings[fax]" id="fax" value="{{ old('settings.fax') }}" class="form-control" />
                                </div>
                            </div>

                            <hr class="mb-4" />

                            <div class="row row-cols-sm-2">
                                <div class="form-group mb-3 col">
                                    <label class="form-label">E-Posta 1</label>
                                    <input type="text" name="settings[email1]" id="email1" value="{{ old('settings.email1') }}" class="form-control" />
                                </div>

                                <div class="form-group mb-3 col">
                                    <label class="form-label">E-Posta 2</label>
                                    <input type="text" name="settings[email2]" id="email2" value="{{ old('settings.email2') }}" class="form-control" />
                                </div>

                                <div class="form-group mb-3 col">
                                    <label class="form-label">E-Posta 3</label>
                                    <input type="text" name="settings[email3]" id="email3" value="{{ old('settings.email3') }}" class="form-control" />
                                </div>

                                <div class="form-group mb-3 col">
                                    <label class="form-label">E-Posta 4</label>
                                    <input type="text" name="settings[email4]" id="email4" value="{{ old('settings.email4') }}" class="form-control" />
                                </div>
                            </div>

                            <hr class="mb-4" />

                            <div class="form-group mb-3">
                                <label class="form-label">Harita</label>
                                <input type="text" name="settings[map]" id="map" value="{{ old('settings.map') }}" class="form-control" />
                            </div>

                            <div class="form-group">
                                <label class="form-label">Yol Tarifi Link</label>
                                <input type="text" name="settings[directions]" id="directions" value="{{ old('settings.directions') }}" class="form-control" />
                            </div>

                            <div class="my-3">
                                <button type="submit" class="btn btn-primary me-2">Kaydet</button>
                            </div>
                        </div>
                </div>

            </div>
        </form>
    </div>
@endsection

@push("styles") @endpush

@push("scripts")
    <script>
        $('#lfmProfile').filemanager('image');
    </script>
@endpush
