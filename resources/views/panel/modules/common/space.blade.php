@extends('panel.modules.form')

@section("general-form")
@endsection

@section("module-form")
    <div class="card">
        <div class="card-body">
            @php
                $desktop    = !empty($model["settings"]["desktop"]) ? $model["settings"]["desktop"] : '';
                $tablet     = !empty($model["settings"]["tablet"]) ? $model["settings"]["tablet"] : '';
                $mobile     = !empty($model["settings"]["mobile"]) ? $model["settings"]["mobile"] : '';
                $color      = !empty($model["settings"]["color"]) ? $model["settings"]["color"] : '';
            @endphp
            <div class="form-group mb-3">
                <label for="settings.desktop" class="form-label">Dekstop</label>
                <input type="number" class="form-control" name="settings[desktop]" id="setting.desktop" value="{{$desktop}}">
            </div>

            <div class="form-group mb-3">
                <label for="settings.tablet" class="form-label">Tablet</label>
                <input type="number" class="form-control" name="settings[tablet]" id="setting.tablet" value="{{$tablet}}">
            </div>

            <div class="form-group mb-3">
                <label for="settings.mobile" class="form-label">Mobile</label>
                <input type="number" class="form-control" name="settings[mobile]" id="setting.mobile" value="{{$mobile}}">
            </div>

            <div class="form-group mb-3">
                <label for="settings.color" class="form-label">Arka Plan Rengi</label>
                <input type="color" class="form-control" name="settings[color]" id="setting.color" value="{{$color}}">
            </div>
        </div>
    </div>
@endsection

@section('modals')
@endsection

@section('styles') @endsection
@section('scripts')
@endsection
