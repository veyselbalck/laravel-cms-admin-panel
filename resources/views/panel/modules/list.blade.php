@extends('panel.layouts.default')

@section('content')

    <div class="row">
        <div class="col-lg-12 col-md-12">

            <div class="row row-cols-md-2 align-items-center">
                <div class="col">
                    <div class="form-group mb-3">
                        <label for="email" class="form-label">Modül Türleri</label>
                        <select id="select2Basic" class="select2 form-select form-select-lg"
                                onchange="window.location.href = '{!! url(request()->route()->uri) . '?code=' !!}' + this.value">
                            @foreach(ModuleCategories() as $k => $v)
                                @if($v["create"])
                                    <option value="{{ $k }}" @if($code == $k) selected @endif >{{ $v["name"] }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                @php
                    $add = false;
                    $copy = false;
                    $delete = false;
                @endphp
                @if(!empty(ModuleCategories()[$code]))
                    @php
                        $add = ModuleCategories()[$code]["add"] ? true : false;
                        $copy = ModuleCategories()[$code]["copy"] ? true : false;
                        $delete = ModuleCategories()[$code]["delete"] ? true : false;
                    @endphp
                    @if($add)
                        <div class="col text-end">
                            <a href="{{route("modules.create", ['code' => $code])}}" class="btn btn-dark"><i class="bx bx-plus"></i> YENİ EKLE</a>
                        </div>
                    @endif
                @endif
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-bordered">
                            <thead class="table-light">
                            <tr>
                                <th>Modül Adı</th>
                                <th>Durumu</th>
                                <th>Eylem</th>
                            </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                            @if(count($model))
                                @foreach($model as $item)
                                    <tr id="item-{{ $item->id }}">
                                        <td>{{$item->name}}</td>
                                        {!! status($item->status, 1, $item->id) !!}
                                        <td style="width: 150px;">
                                            <a href="{{route("modules.edit", [$item->id, 'code' => $code])}}" class="btn btn-xs btn-dark"><i class="bx bx-pencil"></i></a>
                                            @if($copy)
                                                <a href="{{route("modules.copy", [$item->id, 'code' => $code])}}" class="btn btn-xs btn-dark"><i class="bx bx-copy"></i></a>
                                            @endif
                                            @if($delete)
                                                <button type="button" data-id="{{ $item->id }}" class="btn btn-xs btn-danger delete"><i class="bx bx-x"></i></button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="3" class="text-center">Kayıt bulunmamaktadır.</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push("styles") @endpush

@push("scripts")
    <script>

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(".delete").click(function (){
            var destroy_id = $(this).attr("data-id");
            alertify.confirm("Silme işlemini onaylayın!", "Bu işlem geri alınamaz",
                function (){
                    $.ajax({
                        type : "DELETE",
                        url : "{{route('modules.index')}}/" + destroy_id,
                        data: {id:destroy_id},
                        success: function (response){
                            if(response.success){
                                $("#item-" + destroy_id).remove();
                                alertify.success(response.success);
                            } else {
                                alertify.error(response.error);
                            }
                        }
                    });
                },
                function (){
                    alertify.error("Silme işlemi iptal edildi.");
                }
            );
        });
    </script>
@endpush
