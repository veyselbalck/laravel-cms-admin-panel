@extends('panel.layouts.default')

@section('content')

    <div class="row">
        <div class="col-lg-8 col-md-12">
            <div class="card mb-4">
                <form action="{{ route("roles.store") }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Grup Adı</label>
                            <input class="form-control" type="text" required id="name" name="name" value="{{ old("name") }}"/>
                        </div>

                        <div class="form-group mb-3">
                            <label class="switch switch-primary">
                                <input type="checkbox" class="switch-input" name="status" value="1" @if(old("status", 1)) checked @endif />
                                <span class="switch-toggle-slider"><span class="switch-on"><i class="bx bx-check"></i></span><span class="switch-off"><i class="bx bx-x"></i></span></span>
                                <span class="switch-label">Kullanıcı aktif mi?</span>
                            </label>
                        </div>
                    </div>
                    <hr class="my-0" />
                    <div class="card-body">

                        <input type="hidden" name="permission[dashboard][index]" value="1">
                        <div class="table-responsive text-nowrap">
                            <table class="table">
                                <thead class="table-light">
                                <tr>
                                    <th>İzin Türleri</th>
                                    <th class="text-center">Görünüm<br>
                                        <label class="text-primary font-size-sm mb-0 cursor-pointer user-select-none">
                                            <input type="checkbox" class="d-none" onclick="$('.checkbox-index').prop('checked', this.checked)">
                                            @lang('Select All')
                                        </label>
                                    </th>
                                    <th class="text-center">Yeni<br>
                                        <label class="text-primary font-size-sm mb-0 cursor-pointer user-select-none">
                                            <input type="checkbox" class="d-none" onclick="$('.checkbox-create').prop('checked', this.checked)">
                                            @lang('Select All')
                                        </label>
                                    </th>
                                    <th class="text-center">Düzenle<br>
                                        <label class="text-primary font-size-sm mb-0 cursor-pointer user-select-none">
                                            <input type="checkbox" class="d-none" onclick="$('.checkbox-edit').prop('checked', this.checked)">
                                            @lang('Select All')
                                        </label>
                                    </th>
                                    <th class="text-center">Sil<br>
                                        <label class="text-primary font-size-sm mb-0 cursor-pointer user-select-none">
                                            <input type="checkbox" class="d-none" onclick="$('.checkbox-destroy').prop('checked', this.checked)">
                                            @lang('Select All')
                                        </label>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($permissionList as $key => $item)
                                    @php
                                        $array = array();
                                        $array['index']   = !empty($model->permission[$key]["index"]) ? 1 : 0;
                                        $array['create']  = !empty($model->permission[$key]["create"]) ? 1 : 0;
                                        $array['edit']    = !empty($model->permission[$key]["edit"]) ? 1 : 0;
                                        $array['destroy'] = !empty($model->permission[$key]["destroy"]) ? 1 : 0;
                                    @endphp
                                        <tr>
                                            <td>{{ $item->name }}</td>
                                            @foreach($array as $k => $v)
                                            <td class="text-center">
                                                <label class="switch switch-primary" style="margin-right: 2.5rem;">
                                                    <input type="checkbox" class="switch-input checkbox-{{$k}}" name="permission[{{$key}}][{{$k}}]" value="1" @if(old("permission.".$key.".".$k, $v)) checked @endif />
                                                    <span class="switch-toggle-slider"><span class="switch-on"><i class="bx bx-check"></i></span><span class="switch-off"><i class="bx bx-x"></i></span></span>
                                                </label>
                                            </td>
                                            @endforeach
                                        </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="my-3">
                            <button type="submit" class="btn btn-primary me-2">Kaydet</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push("styles") @endpush

@push("scripts")
    <script>
        $('#lfmProfile').filemanager('image');
    </script>
@endpush
