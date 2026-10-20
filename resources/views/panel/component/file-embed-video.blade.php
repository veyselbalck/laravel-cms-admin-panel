@if(!empty($value))
    <div class="embed-responsive embed-responsive-16by9">
        <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{$value}}" frameborder="0" allowfullscreen></iframe>
    </div>
@else
    <div class="embed-responsive embed-responsive-16by9 d-none">
        <iframe class="embed-responsive-item" src="" frameborder="0" allowfullscreen></iframe>
    </div>
@endif

<div class="card-body">
    <div class="media mt-0">
        <div class="media-body">
            <div class="input-group">
                <input type="text" name="{{ $field }}" id="{{ $field }}_thumbnail" {{ empty($required) ? '' : $required }} class="form-control" readonly placeholder="Hiç Dosya Seçilmedi" value="{{ $value }}">
                <div class="input-group-append">
                    <button type="button" class="action btn btn-danger btn-embed-video-delete {{ empty($value) ? 'd-none': ''}}"><i class="bx bx-crosshair"></i></button>
                    <button type="button" class="action btn btn-info btn-embed-video"><i class="bx bx-video"></i></button>
                </div>
            </div>
            @if(!empty($helper))
                <span class="form-text text-muted">{{ $helper }}</span>
            @endif
        </div>
    </div>
</div>

<div id="modal_add_video" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-dark " style="padding: 20px 20px 15px 15px;">
                    @if($model)
                        <h6 class="modal-title modal_name white" style="line-height: 14px;">{{ $model->title  }} Video Düzenle</h6>
                    @else
                        <h6 class="modal-title modal_name white" style="line-height: 14px;">Yeni Video Ekle</h6>
                    @endif
                    <button type="button" class="close" style="padding: 12px 20px 15px 15px;" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <label for="title" class="text-danger">Video ID *</label>
                        <input type="text" class="form-control" id="input-embed-video-id" value="{{!empty($value) ? $value : ''}}" >
                        <span class="form-text text-muted">Youtube linkinde watch?v= sonrasında gelen ID:<br> https://www.youtube.com/watch?v=qUqhjlF8oqU</span>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Kapat</button>
                    <button type="button" class="btn btn-dark" onclick="formSubmit()">Kaydet</button>
                </div>
            </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function(event) {
        $('body').on('click', '.btn-embed-video', function () {
            $('#modal_add_video').modal('show');
            return false;
        });

        $('body').on('click', '.btn-embed-video-delete', function () {
            $('.embed-responsive-item').attr('src', '');
            $('#{{ $field }}_thumbnail').val('')
            $('.embed-responsive-16by9').addClass('d-none');
            $(this).addClass('d-none')
            return false;
        });


    });

    function formSubmit() {
        if($('#input-embed-video-id').val() != ''){
            $('.embed-responsive-item').attr('src', 'https://www.youtube.com/embed/' + $('#input-embed-video-id').val());
            $('.embed-responsive-16by9, .btn-embed-video-delete').removeClass('d-none');

            $('#{{ $field }}_thumbnail').val($('#input-embed-video-id').val());

        }
        $('#modal_add_video').modal('hide');

    }
</script>
