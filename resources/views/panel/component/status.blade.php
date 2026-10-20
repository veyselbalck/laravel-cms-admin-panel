<?php
$confirm = [
    -1 => array(
        'title' => 'Reddedildi',
        'type' => 'warning'
    ),
    0 => array(
        'title' => 'Pasif',
        'type' => 'danger'
    ),
    1 => array(
        'title' => 'Aktif',
        'type' => 'success'
    ),
    2 => array(
        'title' => 'Onay bekliyor',
        'type' => 'primary'
    ),
];

?>
<td class="text-center" width="60">
    <div class="btn-group">
        <a href="#" class="badge bg-{{ $confirm[$status]['type'] }} dropdown-toggle" data-toggle="dropdown" aria-expanded="false">{{ $confirm[$status]['title'] }}</a>
        <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-121px, 19px, 0px);">
            @foreach ($confirm as $key => $value)
                @if($key == $status)
                    <a href="javascript:;" class="dropdown-item active"><span class="badge badge-mark mr-2 bg-{{$value['type']}} border-{{$value['type']}}"></span> {{ $value['title'] }}</a>
                @else
                    {{ Form::open(array('url' => _url('update'), 'method' => 'PUT')) }}
                    <button type="submit" class="dropdown-item "><span class="badge badge-mark mr-2 bg-{{$value['type']}} border-{{$value['type']}}"></span> {{ $value['title'] }}</button>
                    <input type="hidden" name="action" value="status_update">
                    <input type="hidden" name="status" value="{{$key}}">
                    <input type="hidden" name="id" value="{{$id}}">
                    {{ Form::close() }}
                @endif
            @endforeach
        </div>
    </div>
</td>
