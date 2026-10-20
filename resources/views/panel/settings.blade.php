@extends('panel.layouts.default')

@section('content')

    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="mb-4">
                <form action="{{ route("settings.update", $model->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method("PUT")
                    <div class="card shadow-none text-center border mb-3">
                        <div class="card-header border-bottom">
                            <ul class="nav nav-tabs card-header-tabs" role="tablist">
                                @php

                                $tabs = [
                                    'general'   => 'Genel',
                                    'social'    => 'Sosyal Medya',
                                    'local'     => 'Yerel',
                                    'mail'      => 'E-Posta',
//                                    'api'       => 'Api Bilgileri',
                                ];

                                @endphp

                                @foreach($tabs as $key => $v)
                                <li class="nav-item">
                                    <button
                                        type="button"
                                        class="nav-link @if($loop->first) active @endif"
                                        role="tab"
                                        data-bs-toggle="tab"
                                        data-bs-target="#tab-{{$key}}"
                                        aria-controls="tab-{{$key}}"
                                        aria-selected="@if($loop->first) true @else false @endif">
                                        {{$v}}
                                    </button>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="tab-content text-start">
                            <div class="tab-pane fade show active" id="tab-general" role="tabpanel">

                                @php
                                    $name                   = !empty($values->app->name) ? $values->app->name : config("app.name");
                                    $description            = !empty($values->app->description) ? $values->app->description : '';
                                    $email                  = !empty($values->app->email) ? $values->app->email : config("app.email");
                                    $phone                  = !empty($values->app->phone) ? $values->app->phone : config("app.phone");
                                    $whatsapp               = !empty($values->app->whatsapp) ? $values->app->whatsapp : config("app.whatsapp");
                                    $address                = !empty($values->app->address) ? $values->app->address : config("app.address");
                                    $tw_username            = !empty($values->app->tw_username) ? $values->app->tw_username : '';
                                    $logo                   = !empty($values->app->logo) ? $values->app->logo : config("app.logo");
                                    $footer_logo            = !empty($values->app->footer_logo) ? $values->app->footer_logo : config("app.logo");
                                    $open_graph_logo        = !empty($values->app->open_graph_logo) ? $values->app->open_graph_logo : config("app.logo");
                                    $google_analytic        = !empty($values->app->google_analytic) ? $values->app->google_analytic : '';
                                @endphp

                                <div class="form-group mb-3">
                                    <label class="text-danger form-label">Site Adı *</label>
                                    <input type="text" name="value[app][name]" value="{{ old('value.app.name', $name) }}" class="form-control @error('value.app.name') is-invalid @enderror" required>
                                    @error('value.app.name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">Site Açıklaması</label>
                                    <input type="text" name="value[app][description]" value="{{ old('value.app.description', $description) }}" class="form-control">
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">E-posta</label>
                                    <input type="email" name="value[app][email]" value="{{ old('value.app.email', $email) }}" class="form-control" >
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">Telefon</label>
                                    <input type="tel" name="value[app][phone]" value="{{ old('value.app.phone', $phone) }}" class="form-control" >
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">Whatsapp</label>
                                    <input type="tel" name="value[app][whatsapp]" value="{{ old('value.app.whatsapp', $whatsapp) }}" class="form-control" >
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">Adres</label>
                                    <input type="text" name="value[app][address]" value="{{ old('value.app.address', $address) }}" class="form-control" >
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">Twitter Kullanıcı Adı</label>
                                    <input type="text" name="value[app][tw_username]" value="{{ old('value.app.tw_username', $tw_username) }}" class="form-control" >
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">Google Analitik Kodu</label>
                                    <input type="text" name="value[app][google_analytic]" value="{{ old('value.app.google_analytic', $google_analytic) }}" class="form-control" >
                                </div>

                                <div class="form-group mb-3">
                                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                                        <div style="background-color: #efefef; width: 150px; height: 100px;" class="d-flex align-items-center">
                                            <img src="{{ old('value.app.logo', $logo) }}" style="max-width: 150px; max-height: 100px;" class="d-block rounded" id="LogoHolder" />
                                        </div>

                                        <div class="button-wrapper w-100">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Logo</label>
                                                <div class="input-group">
                                                    <div class="input-group-btn">
                                                        <a id="lfmLogo" data-input="thumbLogo" data-preview="LogoHolder" class="btn btn-primary">
                                                            <i class="fa fa-picture-o"></i> Logo Seç
                                                        </a>
                                                    </div>
                                                    <input id="thumbLogo" class="form-control" type="text" name="value[app][logo]" readonly value="{{ old('value.app.logo', $logo) }}">
                                                </div>
                                            </div>

                                            <p class="mb-0">JPG, JPEG, PNG, SVG formatında olması gereklidir.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                                        <div style="background-color: #efefef; width: 150px; height: 100px;" class="d-flex align-items-center">
                                            <img src="{{ old('value.app.footer_logo', $footer_logo) }}" style="max-width: 150px; max-height: 100px;" class="d-block rounded" id="LogoFooterHolder" />
                                        </div>
                                        <div class="button-wrapper w-100">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Footer Logo</label>
                                                <div class="input-group">
                                                    <div class="input-group-btn">
                                                        <a id="lfmFooterLogo" data-input="thumbLogoFooter" data-preview="LogoFooterHolder" class="btn btn-primary">
                                                            <i class="fa fa-picture-o"></i> Logo Seç
                                                        </a>
                                                    </div>
                                                    <input id="thumbLogoFooter" class="form-control" type="text" name="value[app][footer_logo]" readonly value="{{ old('value.app.footer_logo', $footer_logo) }}">
                                                </div>
                                            </div>

                                            <p class="mb-0">JPG, JPEG, PNG, SVG formatında olması gereklidir.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                                        <div style="background-color: #efefef; width: 150px; height: 100px;" class="d-flex align-items-center">
                                            <img src="{{ old('value.app.open_graph_logo', $open_graph_logo) }}" style="max-width: 150px; max-height: 100px;" class="d-block rounded" id="LogoFooterHolder" />
                                        </div>

                                        <div class="button-wrapper w-100">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Open Graph Logo</label>
                                                <div class="input-group">
                                                    <div class="input-group-btn">
                                                        <a id="lfmOpenGraphLogo" data-input="thumbLogoOpenGraph" data-preview="LogoOpenGraphHolder" class="btn btn-primary">
                                                            <i class="fa fa-picture-o"></i> Logo Seç
                                                        </a>
                                                    </div>
                                                    <input id="thumbLogoOpenGraph" class="form-control" type="text" name="value[app][open_graph_logo]" readonly value="{{ old('value.app.open_graph_logo', $open_graph_logo) }}">
                                                </div>
                                            </div>

                                            <p class="mb-0">PNG formatında ve 470*80 piksel boyutlarında olması gereklidir.</p>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="tab-pane fade" id="tab-social" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-sortable">
                                        <tbody>
                                        @foreach($values->frontend->socials as $key => $value)
                                            @php
                                                $href   = !empty($value->href) ? $value->href : $value->href;
                                                $icon   = !empty($value->icon) ? $value->icon : $value->icon;
                                                $status = !empty($value->status) ? intval($value->status) : 0;
                                            @endphp

                                            <tr>
                                                <td class="dragula-handle ui-draggable-handle text-center cursor-move" width="1"> <i class="bx bx-dots-vertical"></i></td>
                                                <td class="text-nowrap" width="1">{{ ucfirst($key) }}</td>
                                                <td>
                                                    <input type="url" name="value[frontend][socials][{{$key}}][href]" value="{{ old('value.frontend.socials.' . $key . '.href' , $href) }}" placeholder="{{ ucfirst($key) . ' Link' }}" class="form-control" >
                                                </td>
                                                <td>
                                                    <textarea name="value[frontend][socials][{{$key}}][icon]" placeholder="Icon" class="form-control">{{ old('value.frontend.socials.' . $key . '.icon', $icon) }}</textarea>
                                                </td>
                                                <td>
                                                    <select class="select2" name="value[frontend][socials][{{$key}}][status]">
                                                        <option value="1" @if(old('value.frontend.socials.' . $key . '.status' , $status) == 1) selected @endif>Aktif</option>
                                                        <option value="0" @if(old('value.frontend.socials.' . $key . '.status' , $status) == 0) selected @endif>Pasif</option>
                                                    </select>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="tab-local" role="tabpanel">

                                @php
                                $zone = !empty($values->app->timezone) ? $values->app->timezone : config("app.timezone");
                                $country = !empty($values->app->country_id) ? $values->app->country_id : config("app.country_id");
                                $city = !empty($values->app->city_id) ? $values->app->city_id : config("app.city_id");
                                $locale = !empty($values->app->locale) ? $values->app->locale : config("app.locale");
                                @endphp
                                <div class="form-group mb-3">
                                    <label class="form-label">Saat Dilimi</label>
                                    <select class="select2 form-control" name="value[app][timezone]">
                                        @foreach(timezone_list() as $timezone )
                                            <option value="{{ $timezone['zone'] }}" @if(old('value.app.timezone', $zone) == $timezone['zone']) selected @endif>
                                                {{ $timezone['zone'] . ' - ' . $timezone['diff_from_GMT'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">Ülke</label>
                                    <select class="select2 form-control" name="value[app][country_id]" onchange="country_select($('select[name=\'value[app][city_id]\']'), this.value)">
                                        @foreach(getCountry() as $country_id => $country_name)
                                            <option value="{{ $country_id }}" @if(old('value.app.country_id', $country) == $country_id) selected @endif>
                                                {{ $country_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">Şehir</label>
                                    <select class="select2 form-control" name="value[app][city_id]" id="input_city">
                                        @foreach(getCity(old('value.app.country_id', config('app.country_id'))) as $city_id => $city_name)
                                            <option value="{{ $city_id }}" @if(old('value.app.city_id', $city) == $city_id) selected @endif>
                                                {{ $city_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">Site Dili</label>
                                    <select class="select2 form-control" name="value[app][locale]">
                                        @foreach(getLanguages() as $language_code => $language_name)
                                            <option value="{{ $language_code }}" @if(old('value.app.locale', $locale) == $language_code) selected @endif>
                                                {{ $language_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="tab-mail" role="tabpanel">
                                @php
                                    $from_emails        = !empty($values->app->from_emails) ? $values->app->from_emails : '';
                                    $host               = !empty($values->mail->mailers->smtp->host) ? $values->mail->mailers->smtp->host : config('mail.mailers.smtp.host');
                                    $port               = !empty($values->mail->mailers->smtp->port) ? $values->mail->mailers->smtp->port : config('mail.mailers.smtp.port');
                                    $encryption         = !empty($values->mail->mailers->smtp->encryption) ? $values->mail->mailers->smtp->encryption : config('mail.mailers.smtp.encryption');
                                    $username           = !empty($values->mail->mailers->smtp->username) ? $values->mail->mailers->smtp->username : config('mail.mailers.smtp.username');
                                    $password           = !empty($values->mail->mailers->smtp->password) ? $values->mail->mailers->smtp->password : config('mail.mailers.smtp.password');
                                    $timeout            = !empty($values->mail->mailers->smtp->timeout) ? $values->mail->mailers->smtp->timeout : config('mail.mailers.smtp.timeout');
                                @endphp

                                <input type="hidden" name="value[mail][mailers][smtp][transport]" value="smtp" >

                                <div class="form-group mb-3">
                                    <label class="form-label">Host Adı</label>
                                    <input type="text" name="value[mail][mailers][smtp][host]"
                                           value="{{ old('value.mail.mailers.smtp.host', $host) }}"
                                           class="form-control" >
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">Port</label>
                                    <input type="text" name="value[mail][mailers][smtp][port]"
                                           value="{{ old('value.mail.mailers.smtp.port', $port) }}"
                                           class="form-control" >
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">Şifreleme</label>
                                    <select name="value[mail][mailers][smtp][encryption]" class="form-control select2">
                                        <option value="ssl" @if(old('value.mail.mailers.smtp.encryption', $encryption) == 'ssl') selected @endif>ssl</option>
                                        <option value="tls" @if(old('value.mail.mailers.smtp.encryption', $encryption) == 'tls' )selected @endif>tls</option>
                                    </select>
                                </div>


                                <div class="form-group mb-3">
                                    <label class="form-label">Kullanıcı Adı</label>
                                    <input type="text" name="value[mail][mailers][smtp][username]"
                                           value="{{ old('value.mail.mailers.smtp.username', $username) }}"
                                           class="form-control">
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">Şifre</label>
                                    <input type="text" name="value[mail][mailers][smtp][password]"
                                           value="{{ old('value.mail.mailers.smtp.password', $password) }}"
                                           class="form-control">
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">Zaman Aşımı</label>
                                    <input type="text" name="value[mail][mailers][smtp][timeout]"
                                           value="{{ old('value.mail.mailers.smtp.timeout', $timeout) }}"
                                           class="form-control">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="mail_to" class="form-label">İletişim Formunun Gönderileceği Mail Adresleri *</label>
                                    <input type="text" name="value[app][from_emails]" value="{{ old('value.app.from_emails', $from_emails) }}" class="form-control" required>
                                    <small class="text-muted">Formun birden çok mail adresine gitmesi için noktalı virgül kullanabilirsiniz</small>
                                    <br>
                                    <small class="text-muted">Örnek: <code>{{'mail@'.str_replace(["https://", "http://"], "", config("app.url"))}}; {{'mail2@'.str_replace(["https://", "http://"], "", config("app.url"))}}</code></small>
                                </div>

                            </div>

                            <div class="tab-pane fade" id="tab-api" role="tabpanel">
                                <fieldset>
                                    <h5 class="text-uppercase font-size-sm font-weight-bold">GOOGLE CAPTCHA</h5>
                                </fieldset>
                                <div class="form-group mb-3">
                                    <label class="form-label">Durumu</label>
                                    <select name="value[frontend][captcha][status]" class="form-control select2" >
                                        @if(old('value.frontend.captcha.status', config('frontend.captcha.status')))
                                            <option value="1" selected>@lang('Active')</option>
                                            <option value="0">@lang('Passive')</option>
                                        @else
                                            <option value="1">@lang('Active')</option>
                                            <option value="0" selected>@lang('Passive')</option>
                                        @endif
                                    </select>
                                </div>


                                <div class="form-group mb-3">
                                    <label class="form-label">Site Key</label>
                                    <input type="text" name="value[frontend][captcha][site_key]"
                                           value="{{ old('value.frontend.captcha.site_key', config('frontend.captcha.site_key')) }}"
                                           class="form-control" >
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">Secret</label>
                                    <input type="text" name="value[frontend][captcha][secret]"
                                           value="{{ old('value.frontend.captcha.secret', config('frontend.captcha.secret')) }}"
                                           class="form-control" >
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary me-2">Kaydet</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push("styles") @endpush

@push("scripts")
    <script>
        $('#lfmLogo').filemanager('image');
        $('#lfmFooterLogo').filemanager('image');
        $('#lfmOpenGraphLogo').filemanager('image');

        var country_select = function (element, country_id) {
            $.ajax({
                url: '/admin/json/city?country_id=' + country_id,
                dataType: 'json',
                beforeSend: function() {

                },
                complete: function() {

                },
                success: function(json) {
                    var html = '<option value="">Seçiniz</option>';
                    if (Object.keys(json).length) {
                        $.each(json, function (key, value) {
                            html += '<option value="' + key + '">' + value + '</option>';
                        })
                    } else {
                        html += '<option value="0" selected="selected"></option>';
                    }

                    $(element).html(html);
                    $(element).select2();
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }
    </script>
@endpush
