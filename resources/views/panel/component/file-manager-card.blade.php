@if(!empty($value))
    <img id="{{ $field }}_holder" src="{{ ImagePreview($value) }}"   style="width: 100%"  alt="">
@else
    <img id="{{ $field }}_holder" src="" class="d-none"  style="width: 100%"  alt="">
@endif

<div class="card-body">
    <div class="media mt-0">
        <div class="media-body">
            <div class="input-group">
                <input type="text" name="{{ $field }}" id="{{ $field }}_thumbnail" {{ empty($required) ? '' : $required }} class="form-control" readonly placeholder="Hiç Dosya Seçilmedi" value="{{ $value }}">
                <div class="input-group-append">
                    <button type="button" data-input="{{ $field }}_thumbnail" data-preview="{{ $field }}_holder" class="action btn btn-danger btn-filemanager-delete {{ empty($value) ? 'd-none': ''}}"><i class="icon-cross"></i></button>
                    <button type="button" data-input="{{ $field }}_thumbnail" data-preview="{{ $field }}_holder" class="action btn btn-info btn-filemanager"><i class="icon-file-picture"></i></button>
                </div>
            </div>
            @if(!empty($helper))
                <span class="form-text text-muted">{{ $helper }}</span>
            @endif
        </div>
    </div>
</div>
