@extends('panel.modules.form')

@section("general-form")
    @php
        $list_type = !empty($model["settings"]["list_type"]) ? $model["settings"]["list_type"] : 'image';
        $column    = !empty($model["settings"]["column"]) ? $model["settings"]["column"] : 4;
    @endphp
    <div class="form-group mb-3">
        <label for="settings.parallax" class="form-label">Listeleme Türü</label>
        <select class="select2 form-control" name="settings[list_type]" id="settings.list_type">
            <option value="icon" @if(old("settings.list_type", $list_type) == 'icon') selected @endif>İkon Gösterimli</option>
            <option value="image" @if(old("settings.list_type", $list_type) == 'image') selected @endif>Görsel Gösterimli</option>
        </select>
    </div>

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
@endsection

@section('modals')
@endsection

@section('styles') @endsection
@section('scripts')
@endsection
