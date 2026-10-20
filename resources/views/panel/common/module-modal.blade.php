<div class="modal fade" id="ModuleModal" aria-hidden="true" style="z-index: 99999999;">
    <div class="modal-dialog modal-lg modal-simple">
        <div class="modal-content p-3 p-md-5">
            <div class="modal-body">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="text-center mb-4">
                    <h3 class="address-title modal-title-add">Modüller</h3>
                </div>

                <ul class="list-group mb-3">
                    @foreach(\App\Models\Panel\Modules::all() as $m)
                        <li class="list-group-item p-2">
                            <div class="d-sm-flex justify-content-between align-items-center">
                                <h6 class="p-0 m-0">{{$m->name}}</h6>
                                <div class="d-sm-flex justify-content-between align-items-center">
                                    {{--                                <div class="text-muted me-2">[module]{{$m->code.".".$m->id}}[/module]</div>--}}
                                    <input type="text" readonly class="form-control form-control-sm me-1" width="200"
                                           name="module" id="module-{{$m->code."-".$m->id}}"
                                           value="[module]{{$m->code.".".$m->id}}[/module]">
                                    <button type="button" class="btn btn-sm btn-dark px-2"
                                            data-text="[module]{{$m->code.".".$m->id}}[/module]"
                                            onclick="copyText('module-{{$m->code."-".$m->id}}')"><i
                                                class="bx bx-copy"></i></button>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
