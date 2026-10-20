
<h6 class="text-muted pt-3">ÇEVİRİLER</h6>
<div class="card">
    <div class="card-body">

        <div class="nav-align-left mb-4">
            <ul class="nav nav-tabs" role="tablist">
                @foreach($localization as $group_key => $groups)
                    <li class="nav-item">
                        <button
                            type="button"
                            class="nav-link {{ $loop->first ? 'active' : '' }}"
                            role="tab"
                            data-bs-toggle="tab"
                            data-bs-target="#tab-{{ $group_key }}"
                            aria-controls="tab-{{ $group_key }}"
                            aria-selected="true">
                            {{ \Illuminate\Support\Str::ucfirst($group_key) }}
                        </button>
                    </li>
                @endforeach
            </ul>
            <div class="tab-content">

                @foreach($localization as $group_key => $groups)
                    <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="tab-{{  $group_key }}">
                        <table class="table table-bordered table-sm">
                            <thead>
                            <tr>
                                <th>KEY</th>
                                <th>{{$_lang_name}} (ORJİNAL)</th>
                                @if($model)
                                    <th width="50%">{{ \Illuminate\Support\Str::upper($model->name) }}</th>
                                @else
                                    <th width="50%"></th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($groups as $item_key => $value)
                                @php $trans_value = !empty($translations[$group_key]) && !empty($translations[$group_key][$item_key]) ? $translations[$group_key][$item_key] : $value @endphp
                                <tr>
                                    <td>{{$group_key}}.{{$item_key}}</td>
                                    <td>{{$value}}</td>
                                    <td>
                                        <input class="form-control" name="localization[{{$group_key}}]{{ '[' . implode('][', explode('.', $item_key)) . ']' }}" type="text" value="{{ $trans_value }}">
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
