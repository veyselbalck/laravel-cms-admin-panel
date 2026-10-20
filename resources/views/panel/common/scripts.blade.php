<script src="/panel/assets/vendor/libs/popper/popper.js"></script>
<script src="/panel/assets/vendor/js/bootstrap.js"></script>
<script src="/panel/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

<script src="/panel/assets/vendor/libs/hammer/hammer.js"></script>

<script src="/panel/assets/vendor/js/menu.js"></script>

<!-- Vendors JS -->
<script src="/panel/assets/vendor/libs/select2/select2.js"></script>
<script src="/panel/assets/vendor/libs/tagify/tagify.js"></script>
<script src="/panel/assets/vendor/libs/bootstrap-select/bootstrap-select.js"></script>
<script src="/panel/assets/vendor/libs/typeahead-js/typeahead.js"></script>
<script src="/panel/assets/vendor/libs/bloodhound/bloodhound.js"></script>

<script src="/panel/assets/vendor/libs/bs-stepper/bs-stepper.js"></script>
<script src="/panel/assets/vendor/libs/rateyo/rateyo.js"></script>
<script src="/panel/assets/vendor/libs/cleavejs/cleave.js"></script>
<script src="/panel/assets/vendor/libs/cleavejs/cleave-phone.js"></script>
<script src="/panel/assets/vendor/libs/block-ui/block-ui.js"></script>
<script src="/panel/assets/vendor/libs/sortablejs/sortable.js"></script>
<script src="/panel/assets/vendor/libs/flatpickr/flatpickr.js"></script>
<script src="/panel/assets/vendor/libs/flatpickr/flatpickr-tr.js"></script>


<script src="{{ asset("plugins/nestable/jquery.nestable.js") }}"></script>

<script src="/panel/assets/js/main.js"></script>

<script src="/panel/assets/js/forms-selects.js"></script>
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>

<script src="/panel/assets/js/forms-pickers.js"></script>
<script src="/panel/js/scripts.js"></script>

<script>
    if($('.table-sortable').length){
        $( ".table-sortable > tbody").sortable( {
            items: "tr:not(.custom-collapse)",
            helper: Panel.fixWidthHelper,
            handle: ".dragula-handle",
            axis: 'y',
            start: function(e, ui){
                ui.placeholder.height(ui.item.height());
                var key = $(this).parent("table").attr("data-key");

                if(key === "items") {
                    setTimeout(function () {
                        const elements = document.querySelectorAll('input[data-edit-name=sort_order]');
                        let index = 1;
                        elements.forEach(el => {
                            $(el)[0].value = index;
                            index++;
                        })
                    }, 1000)
                }
            }
        }).disableSelection();
    }

</script>

@stack('scripts')

<script src="{{ asset("plugins/editors/ckeditor/ckeditor.js") }}"></script>
<script src="{{ asset("plugins/editors/ckeditor/adapters/jquery.js") }}"></script>
