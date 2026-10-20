<div class="{{$div_column}}">
    <div class="card mb-4">
        <div id="description" class="card-body datatable-vip">
            <div class="card-header d-md-flex justify-content-end align-items-center pb-0">
                <div class="header-elements text-end">

                    @if (count($filters))
                        <form method="get" class="me-1 d-inline-block filter" style="width: 200px;">
                            @foreach ($filters as $filter_field => $filter_options)
                                @if($filter_options['type'] == 'filters')
                                    <select name="filters[{{ $filter_field }}]" class="select2 me-3" data-title="{{ $filter_options['title'] }}" multiple data-max-options="1" data-live-search="{{ $filter_options['search'] }}" data-size="10" onchange="this.form.submit()">
                                        @foreach ($filter_options['values'] as $filter_value => $filter_title)
                                            <option value="{{ $filter_value }}" {{  $filter_options['active'] == $filter_value || (request('filters.' . $filter_field) != '' && request('filters.' . $filter_field) == $filter_value) ? "selected" : "" }} >{{ $filter_title }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <select class="select2 me-3" data-title="{{ $filter_options['title'] }}" data-live-search="{{ $filter_options['search'] }}" data-size="10" onchange="window.location = this.value">
                                        <option value="{{ _route('index') }}">Seçimi Kaldır</option>
                                        <option data-divider="true"></option>
                                        @foreach ($filter_options['values'] as $filter_value => $filter_title)
                                            <option value="{{ _route('show', $filter_value) }}" {{  $filter_options['active'] == $filter_value || (request('filters.' . $filter_field) != '' && request('filters.' . $filter_field) == $filter_value) ? "selected" : "" }} >{{ $filter_title }}</option>
                                        @endforeach
                                    </select>
                                @endif

                            @endforeach
                        </form>
                    @endif

                    @if (count($search))
                        <form method="get" class="me-1 d-inline-block" style="width: 200px;">
                            <div class="form-group-feedback form-group-feedback-right">
                                <input name="q" type="search" class="form-control" placeholder="Ara..." value="{{ request()->get('q') }}">
                            </div>
                        </form>
                    @endif
                    @if (isset($deleted) && $deleted)
                        <a href="#" class="btn btn-danger buttons-delete-all me-1 mt-0 d-none" data-delete-title="UYARI" data-delete-message="Seçilenleri silmek istediğinizden emin misiniz?"><i class="bx bx-trash-alt mr1"></i> SEÇİLENLERİ SİL</a>
                    @endif
                    @if(isset($created) && $created)
                        <a href="{{ !empty($created_link) ? $created_link : _url('create') }}" class="btn btn-dark me-1 mt-0"><i class="bx bx-plus"></i> YENİ EKLE</a>
                    @endif

                    @if(isset($top_html) && $top_html)
                        {!! $top_html !!}
                    @endif

                    @if($limited)
                        <select class="select2" onchange="window.location.href = '{!! url(request()->route()->uri) . '?limit=' !!}' + this.value" data-width="auto">
                            <option value="10"  {{ $limit == 10 ? "selected" : "" }}>10</option>
                            <option value="25"  {{ $limit == 25 ? "selected" : "" }}>25</option>
                            <option value="50"  {{ $limit == 50 ? "selected" : "" }}>50</option>
                            <option value="100" {{ $limit == 100 ? "selected" : "" }}>100</option>
                            <option value="1000" {{ $limit == 1000 ? "selected" : "" }}>Tümü</option>
                        </select>
                    @endif
                </div>
            </div>

            <div class="card-content pb-2 p-0 pt-2">
                <div class="card-body py-0">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped table-lg datatable-com {{ isset($sortable) && $sortable ? 'dropdown-menu-sortable' : '' }}">
                            <thead>
                            <tr>
                                @if(!empty($sub_fields))
                                    <th width="60">#</th>
                                @endif

                                @if (isset($data) && count($data) && isset($deleted) && $deleted)
                                    <th width="60">
                                        <div class="form-check">
                                            <input class="form-check-input select-all" type="checkbox" data-fouc/>
                                        </div>
                                    </th>
                                @endif


                                @foreach ($fields as $key => $field)
                                    @if ($key == "status")
                                        @php($field['class'] = "text-center")
                                    @endif
                                    @if(isset($field["sort"]))
                                        <th {!! isset($field['th']) ? $field['th'] : "" !!} {!! isset($field['class']) ? 'class="' . $field['class'] . '"' : "" !!} style="min-width: 130px">
                                            @if(request()->has('sort') && request()->get('sort') == $key)
                                                @if(request()->get('order') == 'ASC')
                                                    <a href="{{ _urlTo(request()->segment(2), array('sort' => $key, 'order' => 'DESC'  )) }}" class="d-block">{{$field['title']}}<i class="bx bx-sort-a-z float-end" style="margin-top: 2px"></i></a>
                                                @else
                                                    <a href="{{ _urlTo(request()->segment(2), array('sort' => $key, 'order' => 'ASC'  )) }}" class="d-block">{{$field['title']}}<i class="bx bx-sort-z-a float-end" style="margin-top: 2px"></i></a>
                                                @endif
                                            @else
                                                <a href="{{ _urlTo(request()->segment(2), array('sort' => $key, 'order' => 'ASC'  )) }}" class="d-block">{{$field['title']}}<i class="bx bx-sort-a-z float-end" style="margin-top: 2px"></i></a>
                                            @endif
                                        </th>
                                    @else
                                        <th {!! isset($field['th']) ? $field['th'] : "" !!} {!! isset($field['class']) ? 'class="' . $field['class'] . '"' : "" !!}>{{$field['title']}}</th>
                                    @endif

                                @endforeach
                                @if(isset($sortable) && $sortable)
                                    <th width="60"><i class="bx bxs-sort-alt dragula-handle"></i></th>
                                @endif
                                @if (isset($edited) && $edited)
                                    <th class="text-center" width="70">EYLEM</th>
                                @endif
                            </tr>
                            </thead>

                            <tbody>
                            @if (isset($data) && count($data))
                                @foreach ($data as $row)
                                        <?php $removed = isset($row->deleted_at) && $row->deleted_at != null ?>
                                    <tr data-id="{{$row->$primarykey}}" class="{{ $removed ? 'table-danger1' : '' }}">
                                        @if(!empty($sub_fields))
                                            <td>
                                                <a href="#collapse-{{$row->$primarykey}}" class="collapsed" data-bs-toggle="collapse" data-target="" aria-expanded="false" >
                                                    <i class="bx bx-chevrons-down"></i>
                                                </a>
                                            </td>
                                        @endif

                                        @if (isset($deleted) && $deleted)
                                            <td class="select-checkbox"></td>
                                        @endif

                                        @foreach ($fields as $key => $field)
                                            @if ($key == "status" && !isset($field['cb']))
                                                <td width="80" class="text-center">{!! status($row->$key) !!}</td>
                                            @elseif (isset($field['cb']) && gettype($field['cb']) == 'object')
                                                    <?php $ret = $field['cb']($row); ?>
                                                @if(strpos($ret, '</td>'))
                                                    {!! $field['cb']($row) !!}
                                                @else
                                                    <td>{!! $field['cb']($row) !!}</td>
                                                @endif
                                            @else
                                                <td>{!! $row->$key !!}</td>
                                            @endif
                                        @endforeach
                                        @if(isset($sortable) && $sortable)
                                            <td class="dragula-handle"><i class="bx bxs-sort-alt"></i></td>
                                        @endif
                                        @if (isset($edited) && $edited)
                                            <td class="text-center">
                                                @if($removed)
                                                    <a href="javascript:;" data-id="{{$row->$primarykey}}" class="list-icons-item text-slate-700 buttons-delete-back" title="Silineni Geri Al" data-delete-title="UYARI" data-delete-message="Geri almak istediğinizden emin misiniz?"><i class="bx bx-redo"></i></a>
                                                @else
                                                    <a href="{{ _url($row->$primarykey . '/edit') }}" class="list-icons-item text-slate-700" title="Düzenle"><i class="bx bx-pencil"></i></a>
                                                @endif
                                            </td>
                                        @endif

                                        @if (isset($category_filters) && $category_filters)
                                            <td class="text-center">
                                                @if($row->role == "product")
                                                    <a href="{{ route("category.filters", $row->$primarykey) }}" class="list-icons-item text-slate-700" title="Filtreleri Düzenle"><i class="icon-filter3"></i></a>
                                                @endif
                                            </td>
                                        @endif
                                    </tr>
                                    @if(!empty($sub_fields))
                                        <div class="unsortable">
                                            <tr class="custom-collapse collapse" id="collapse-{{$row->$primarykey}}">
                                                <td colspan="20" class="p-0">
                                                    <table class="card card-table table-responsive shadow-0 mb-0 border-top-0 border-bottom-0 " style="border-top-left-radius: 0; border-top-right-radius: 0;">
                                                        <tbody>
                                                        @foreach ($sub_fields as $skey => $sfield)
                                                            <tr style="width: 100%">
                                                                <th style="white-space: nowrap">{{ $sfield['title'] }}</th>
                                                                @if (isset($sfield['cb']) && gettype($sfield['cb']) == 'object')
                                                                    <td width="100%">{!! $sfield['cb']($row) !!}</td>
                                                                @else
                                                                    <td width="100%">{!! $row->$skey !!}</td>
                                                                @endif
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </div>
                                    @endif
                                @endforeach
                            @else
                                <tr><td colspan="10">KAYIT BULUNAMADI</td></tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer bg-white d-flex justify-content-between align-items-center">
                        @if (isset($data))
                            <ul class="list-inline mb-0">
                                <li class="list-inline-item">GÖSTERİLEN: <span class="first_item">{{ $data->firstItem() }}</span> İLE {{ $data->lastItem() }} ARASI, TOPLAM: <span class="total">{{ $data->total() }}</span> ({{ $data->lastPage() }} SAYFA)</li>
                                <li class="list-inline-item select-item" ></li>
                            </ul>
                            {!! $data->links() !!}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .table th, .table td { padding: .8rem 1rem;}
    .card .card-footer { padding-left: 0 !important; padding-right: 0 !important;}
</style>
