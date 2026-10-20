@extends('panel.layouts.default')
@section('content')
    @php
        $route_form = route("modules.store", ["code" => $code]);
        $method = "POST";
        $name = "";
        $status = 1;
    if(!empty($form)){
        $route_form = route("modules.update", [$model->id, "code" => $code]);
        $method = "PUT";

        $name = $model->name;
        $status = $model->status;
    }
    @endphp
    <form action="{{ $route_form }}" method="post" enctype="multipart/form-data">
        @csrf
        @method($method)

        <div class="w-full text-end mb-3" style="margin-top: -45px;">
            <button type="submit" class="btn btn-warning"><i class="bx bxs-save"></i> Kaydet</button>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card mb-4">
                    <hr class="my-0" />
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="name" class="form-label text-danger">Modül Adı *</label>
                            <input class="form-control" type="text" required id="name" name="name" value="{{ old("name", $name) }}"/>
                        </div>

                        <div class="form-group mb-3">
                            <label for="email" class="form-label">Modül Durumu</label>
                            <select class="select2 form-control" name="status">
                                <option value="1" @if(old("status", 1) == $status) selected @endif>Aktif</option>
                                <option value="0" @if(old("status", 0) == $status) selected @endif>Pasif</option>
                            </select>
                        </div>
                        @yield("general-form")
                    </div>
                </div>

                @yield("module-form")
            </div>
        </div>
    </form>

    @yield("FormNot")

    @yield("modals")
@endsection

@push("styles")
    @yield('styles')
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/drag-drop/dragula.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('plugins/drag-drop/drag-and-drop.css')}}">
@endpush

@push("scripts")
    <script src="{{asset('plugins/drag-drop/dragula.min.js')}}"></script>
    <script src="{{asset('plugins/drag-drop/drag-drop.js')}}"></script>
    @yield('scripts')
@endpush
