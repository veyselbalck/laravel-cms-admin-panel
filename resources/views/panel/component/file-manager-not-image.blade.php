<div class="input-group">
    <input type="text" name="{{ $field }}" id="{{ empty($id) ? $field : $id }}_thumbnail" class="form-control" readonly placeholder="Hiç Dosya Seçilmedi" value="{{ $value }}">
    <div class="input-group-append">
        <button type="button" data-input="{{ empty($id) ? $field : $id }}_thumbnail" data-preview="{{ empty($id) ? $field : $id }}_holder" class="action btn btn-danger btn-filemanager-delete {{ empty($value) ? 'd-none': ''}}"><i class="icon-cross"></i></button>
        <button type="button" data-input="{{ empty($id) ? $field : $id }}_thumbnail" data-preview="{{ empty($id) ? $field : $id }}_holder" class="action btn btn-info btn-filemanager">Dosya Seçiniz</button>
    </div>
</div>
@if(!empty($helper))
    <span class="form-text text-muted">{{ $helper }}</span>
@endif
