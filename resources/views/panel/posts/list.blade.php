@extends('panel.layouts.default')

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card mb-4">
                <div class="card-header d-md-flex justify-content-end align-items-center">
                    <div class="header-elements d-flex">

                        <div class="form-group mb-0 me-1">
                            <div class="input-group">
                                <input type="text" class="form-control w-25" id="tree-filter" name="filter" placeholder="Filter...">
                                <button class="btn btn-danger p-2" type="button" id="btnResetSearch"><i class="bx bx-x"></i></button>
                            </div>
                        </div>
{{--                        <div class="form-group mb-0">--}}
{{--                            <button onclick="expandToggle()" class="btn btn-primary me-1"><i class='bx bx-expand-alt me-1'></i> Expand</button>--}}
{{--                        </div>--}}

                        <a href="{{route("posts.create")}}" class="btn btn-secondary"><i class="bx bx-plus"></i> Yeni Ekle</a>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Table tree -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover dataTable tree-table">
                            <thead>
                            <tr>
                                <th width="1" class="text-center d-none">#</th>
                                <th width="1" class="text-center">ID</th>
                                <th>Post Adı</th>
{{--                                <th width="1" class="text-nowrap">{{ trans('panel/contents.subdomain') }}</th>--}}
                                <th class="text-center text-nowrap" width="200">Kategori</th>
                                <th class="text-center text-nowrap" width="150">Şablon</th>
                                <th class="text-center text-nowrap" width="150">Tarih</th>
                                <th class="text-center" width="1">Durum</th>
{{--                                <th class="text-center" width="1">Modüller</th>--}}
                                    <th class="text-center" width="1">Düzenle</th>
                                    <th class="text-center" width="1">Sil</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="dragula-handle cursor-move d-none"><i class="bx bx-dots-vertical"></i></td>
                                <td data-key="id"></td>
                                <td data-key="title"></td>
{{--                                <td data-key="subdomain"></td>--}}
                                <td data-key="parent" class="text-center"></td>
                                <td data-key="template" class="text-center"></td>
                                <td data-key="date" class="text-center"></td>
                                <td data-key="status" data-type="status" class="text-center"></td>
{{--                                <td data-key="module" class="text-center"></td>--}}
                                    <td class="text-center p-0">
                                        <a href="" class="btn btn-xs btn-primary item-edit" data-bs-popup="tooltip" title="Düzenle"><i class="bx bx-pencil"></i></a>
                                    </td>
                                    <td class="text-center p-0">
                                        <a href="javascript:;" class="btn btn-xs btn-danger item-destroy" data-bs-popup="tooltip"
                                           title="Sil" onclick="ContentDelete($(this))"><i class="bx bx-trash"></i></a>
                                    </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /table tree -->
                </div>
            </div>
        </div>
    </div>

    <!-- Remove modal -->
    <div class="modal fade" id="remove_modal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="form-delete" method="post">
                @csrf
                @method('delete')
                <input type="hidden" id="form-id" name="id" value="">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Silme Onayı</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">İçerik silinsin mi? Bu işlem geri alınamaz!</div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning">{{ trans('Evet, Sil') }}</button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ trans('Vazgeç') }}</button>
                </div>
            </div>
            </form>
        </div>
    </div>
    <!-- /remove modal -->
@endsection

@push("styles")
@endpush

@push("scripts")
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var element = $('.tree-table');
            $(element).fancytree({
                extensions: ['table', "dnd", "persist", "filter"],
                checkbox: false,
                quicksearch: true,
                table: {
                    indentation: 15,      // indent 20px per node level
                    nodeColumnIdx: 2,     // render the node title into the 2nd column
                },
                source: JSON.parse('{!! $contents !!}'),
                filter: {
                    autoApply: true,   // Re-apply last filter if lazy data is loaded
                    autoExpand: true, // Expand all branches that contain matches while filtered
                    counter: false,     // Show a badge with number of matching child nodes near parent icons
                    fuzzy: true,      // Match single characters in order, e.g. 'fb' will match 'FooBar'
                    hideExpandedCounter: true,  // Hide counter badge if parent is expanded
                    hideExpanders: true,       // Hide expanders if all child nodes are hidden by filter
                    highlight: true,   // Highlight matches by wrapping inside <mark> tags
                    leavesOnly: true, // Match end nodes only
                    nodata: true,      // Display a 'no data' status node if result is empty
                    mode: "hide"       // Grayout unmatched nodes (pass "hide" to remove unmatched node instead)
                },
                dnd: {
                    autoExpandMS: 400,
                    preventVoidMoves: true, // Prevent dropping nodes 'before self', etc.
                    preventRecursiveMoves: true, // Prevent dropping nodes on own descendants
                    dragStart: function(node, data) {
                        return true;
                    },
                    dragEnter: function(node, data) {
                        return true;
                    },
                    dragDrop: function(node, data) {
                        // This function MUST be defined to enable dropping of items on the tree.
                        data.otherNode.moveTo(node, data.hitMode);

                        var neworder = new Array();
                        node.getParent().visit(function(all_drop_data){
                            neworder.push(all_drop_data.data.id);
                        });


                        var parent_id = data.otherNode.parent.data.id == 'root_1' ? null : data.otherNode.parent.data.id;

                        $.ajax({
                            url: '/admin/json/content_sort_order',
                            type: 'post',
                            data: {
                                _token: '{{ csrf_token() }}',
                                _method: 'PUT',
                                id:data.otherNode.data.id,
                                parent_id:parent_id,
                                sort_order:neworder,
                            },
                            beforeSend: function() {
                                $.blockUI({
                                    message: '<span class="font-weight-semibold"><i class="icon-spinner4 spinner mr-2"></i>&nbsp; Lütfen Bekleyin..</span>',
                                    css: {
                                        top: '50%',
                                        border: 0,
                                        color: '#fff',
                                        padding: 0,
                                        backgroundColor: 'transparent'
                                    },
                                });
                            },
                            success: function(response){
                                window.location.reload();
                            },
                            complete: function() {
                                //$.unblockUI();
                            },
                        });
                    },
                    draggable:{ handle: ".dragula-handle" }
                },
                persist: {
                    expandLazy: true,
                    // fireActivate: false,    // false: suppress `activate` event after active node was restored
                    overrideSource: false,  // true: cookie takes precedence over `source` data attributes.
                    store: "auto" // 'cookie', 'local': use localStore, 'session': sessionStore
                    // Sample for a custom store:
                    // store: {
                    //   get: function(key){ this.info("get(" + key + ")"); return window.sessionStorage.getItem(key); },
                    //   set: function(key, value){ this.info("set(" + key + ", " + value + ")"); window.sessionStorage.setItem(key, value); },
                    //   remove: function(key){ this.info("remove(" + key + ")"); window.sessionStorage.removeItem(key); }
                    // }
                },
                renderColumns: function(event, data) {
                    var node = data.node
                    $(node.tr).find("[data-key]").each(function () {
                        var key = $(this).data('key');
                        switch ($(this).data('type')){
                            case 'status':
                                $(this).html(node.data[key] ? '<span class="badge bg-success">Aktif</span>' : '<span class="badge bg-danger">Pasif</span>');
                                break;
                            case 'link':
                                $(this).html('<a href="'+node.data[key].link+'">'+node.data[key].title+'</a>');
                                break;
                            case 'button':
                                $(this).html('<a href="'+node.data[key].link+'">'+node.data[key].title+'</a>');
                                break;
                            default:
                                $(this).html(node.data[key]);
                        }
                    })

                    if($(node.tr).find('.item-edit').length > 0){
                        $(node.tr).find('.item-edit').attr('href', node.data.edit);
                    }

                    if($(node.tr).find('.item-destroy').length > 0){
                        $(node.tr).find('.item-destroy').attr('data-action', node.data.destroy);
                        $(node.tr).find('.item-destroy').attr('data-id', node.data.id);
                    }
                }
            });

            var tree = $.ui.fancytree.getTree(".tree-table");

            $("button#btnResetSearch").click(function(e){
                $("#tree-filter").val("");
                $("span#matches").text("");
                tree.clearFilter();
            }).attr("disabled", true);

            $("#tree-filter").on("keyup", function(e){
                var n,
                    tree = $.ui.fancytree.getTree(),
                    match = $(this).val();

                if(e && e.which === $.ui.keyCode.ESCAPE || $.trim(match) === ""){
                    $("button#btnResetSearch").trigger("click");
                    return;
                }

                n = tree.filterBranches.call(tree, match, {});


                $("button#btnResetSearch").attr("disabled", false);

            });

        });

        function expandToggle() {
            $.ui.fancytree.getTree(".tree-table").visit(function(node){
                node.toggleExpanded();
            });
        }

        var ContentDelete = function (elem){
            var action = elem.attr('data-action');
            var id = elem.attr('data-id');
            document.getElementById('form-delete').action = action;
            document.getElementById('form-id').value = id;
            $('#remove_modal').modal('show');

        }

    </script>
@endpush
