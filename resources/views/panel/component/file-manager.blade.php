<div class="media mt-0">
    <div class="media-body">
        @if(!empty($value))
            <img id="{{ $field }}_holder" src="{{ ImagePreview($value) }}" class="mb-2"  style="width: 100%"  alt="">
        @else
            <img id="{{ $field }}_holder" src="" class="mb-2 d-none"  style="width: 100%"  alt="">
        @endif

        <div class="input-group">
            <input type="text" name="{{ $field }}" id="{{ $field }}_thumbnail" class="form-control" readonly placeholder="Hiç Dosya Seçilmedi" value="{{ $value }}">
            <div class="input-group-append">
                <button type="button" data-input="{{ $field }}_thumbnail" data-preview="{{ $field }}_holder" class="action btn btn-danger btn-filemanager-delete {{ empty($value) ? 'd-none': ''}}"><i class="icon-cross"></i></button>
                <button type="button" data-input="{{ $field }}_thumbnail" data-preview="{{ $field }}_holder" class="action btn btn-info btn-filemanager">Dosya Seçiniz</button>
            </div>
        </div>
        @if(!empty($helper))
        <span class="form-text text-muted">{{ $helper }}</span>
        @endif
    </div>
</div>
