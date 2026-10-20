@extends('panel.modules.form')

@section("general-form")
    @php
        $parallax   = !empty($model["settings"]["parallax"]) ? $model["settings"]["parallax"] : 0;
        $links   = !empty($model["settings"]["links"]) ? $model["settings"]["links"] : 0;
    @endphp
    <div class="form-group mb-3">
        <label for="settings.parallax" class="form-label">Parallax Görsel Mi?</label>
        <select class="select2 form-control" name="settings[parallax]" id="settings.parallax">
            <option value="1" @if(old("settings.parallax", $parallax) == 1) selected @endif>Aktif</option>
            <option value="0" @if(old("settings.parallax", $parallax) == 0) selected @endif>Pasif</option>
        </select>
    </div>

    <div class="form-group mb-3">
        <label for="settings.parallax" class="form-label">URL Haritası Gösterilsin Mi?</label>
        <select class="select2 form-control" name="settings[links]" id="settings.links">
            <option value="1" @if(old("settings.links", $parallax) == 1) selected @endif>Aktif</option>
            <option value="0" @if(old("settings.links", $parallax) == 0) selected @endif>Pasif</option>
        </select>
    </div>
@endsection

@section("module-form")
@endsection

@section('modals')
@endsection

@section('styles') @endsection
@section('scripts')
@endsection
