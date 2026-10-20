
var slugify = function(text) {
    var trMap = {
        'çÇ':'c',
        'ğĞ':'g',
        'şŞ':'s',
        'üÜ':'u',
        'ıİ':'i',
        'öÖ':'o'
    };
    for(var key in trMap) {
        text = text.replace(new RegExp('['+key+']','g'), trMap[key]);
    }
    return  text.replace(/[^-a-zA-Z0-9\s]+/ig, '') // remove non-alphanumeric chars
        .replace(/\s/gi, "-") // convert spaces to dashes
        .replace(/[-]+/gi, "-") // trim repeated dashes
        .toLowerCase();

}

const toggler = document.querySelectorAll('.form-password-toggle i')
if (typeof toggler !== 'undefined' && toggler !== null) {
    toggler.forEach(el => {
        el.addEventListener('click', e => {
            e.preventDefault()
            const formPasswordToggle = el.closest('.form-password-toggle')
            const formPasswordToggleIcon = formPasswordToggle.querySelector('i')
            const formPasswordToggleInput = formPasswordToggle.querySelector('input')

            if (formPasswordToggleInput.getAttribute('type') === 'text') {
                formPasswordToggleInput.setAttribute('type', 'password')
                formPasswordToggleIcon.classList.replace('bx-show', 'bx-hide')
            } else if (formPasswordToggleInput.getAttribute('type') === 'password') {
                formPasswordToggleInput.setAttribute('type', 'text')
                formPasswordToggleIcon.classList.replace('bx-hide', 'bx-show')
            }
        })
    })
}

var Panel = {
    fixWidthHelper: function (e, ui) {
        ui.children().each(function() {
            $(this).width($(this).width());
        });

        return ui;
    },
    uid: function () {
        return Math.floor(Math.random() * 26) + Date.now();
    },
    country:function (element, country_id) {
        $.ajax({
            url: '/json/city?country_id=' + country_id,
            dataType: 'json',
            beforeSend: function() {

            },
            complete: function() {

            },
            success: function(json) {
                var html = '<option value="">Seçiniz</option>';
                if (Object.keys(json).length) {
                    $.each(json, function (key, value) {
                        html += '<option value="' + key + '">' + value + '</option>';
                    })
                } else {
                    html += '<option value="0" selected="selected"></option>';
                }

                $(element).html(html);
                $(element).select2();
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    },

    autoComplete:function (item, url, callback, source) {

        $(item).focus(function(){
            if($(this).val() == ""){
                $(this).val('');
                $(this).keydown();
            }
        });

        $(item).autocomplete({
            minLength: 0,
            'source': function(request, response) {
                var params = {
                    filter_name: request.term
                }
                if(source){
                    params = source(request);
                }

                $.ajax({
                    url: url,
                    dataType: "json",
                    data: params,
                    success: function(json) {
                        response(json);
                    },
                    beforeSend: function( xhr ) {
                        $(item).parent().addClass('ui-autocomplete-processing ui-autocomplete-loading');
                        $(item).removeClass('is-invalid');
                    },
                    complete:function () {
                        $(item).parent().removeClass('ui-autocomplete-processing');
                    }
                });
            },

            'select': function(event, ui) {
                callback(ui.item, item);
                return false;
            }
        });
    }
}


$('[auto-complete]').each(function () {

    var json_url = $(this).attr('auto-complete')

    $(this).autocomplete({
        minLength: 0,
        'source': function(request, response) {

            $.ajax({
                url: json_url,
                dataType: "json",
                data: {
                    filter_name: request.term,
                },
                success: function(json) {
                    response(json);
                }
            });
        },
        search: function() {
            $(this).parent().addClass('ui-autocomplete-processing ui-autocomplete-loading');
            $(this).removeClass('is-invalid');
        },
        open: function() {
            $(this).parent().removeClass('ui-autocomplete-processing');
        },
        'select': function(event, ui) {
            $(this).val(ui.item.label);
            $(this).next('input').val(ui.item.value);
            return false;
        }
    });
});
var _componentCKEditor = function() {
    if (typeof CKEDITOR == 'undefined') {
        console.warn('Warning - ckeditor.js is not loaded.');
        return;
    }


    // Full featured editor
    // ------------------------------

    CKEDITOR.on('dialogDefinition', function (ev) {
        var dialogName = ev.data.name;
        var dialogDefinition = ev.data.definition;
        if (dialogName === 'table' || dialogName === 'tableProperties') {
            dialogDefinition.getContents('advanced').get('advCSSClasses')['default'] = 'table table-bordered';
            dialogDefinition.getContents('advanced').get('advStyles')['default'] = '';

            var info = dialogDefinition.getContents('info');
            info.get('txtWidth')['default'] = '100%';
            info.get('txtRows')['default'] = '2';
        }

        if(dialogName === 'cellProperties'){
            dialogDefinition.getContents('info').get('widthType')['default'] = '%';
            dialogDefinition.getContents('info').get('heightType')['default'] = '%';
        }
    });

    CKEDITOR.dtd.$removeEmpty['i'] = false;


    $('.editor-ck').each(function (index, elem) {
        var height = $(elem).data('height') ? $(elem).data('height') : 500;
        editor = $(elem).ckeditor({
            language                : 'tr',
            startupOutlineBlocks    : true,
            height                  : height,
            format_tags             : 'p;h1;h2;h3;h4;h5;h6;pre',
            removeDialogTabs        : 'image:advanced;link:advanced',
            allowedContent          : true,
            extraPlugins            : 'bootstrap, automodule, bt_table',
            removePlugins           : 'sourcearea',
            contentsCss             : [
                '/plugins/icons/icomoon/style.css',
                '/plugins/editors/ckeditor/custom.css',
            ],
            filebrowserImageBrowseUrl: '/filemanager?type=Images',
            filebrowserImageUploadUrl: '/filemanager/upload?type=Images&_token=',
            filebrowserBrowseUrl: '/filemanager?type=Files',
            filebrowserUploadUrl: '/filemanager/upload?type=Files&_token='


            /*
            toolbar                 : [
                { name: 'clipboard', items: [ 'Undo', 'Redo'] },
                { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock' ] },
                { name: 'styles', items: [ 'TextColor', 'BGColor' ] },
                { name: 'insert', items: [ 'Image', 'Table', 'HorizontalRule', 'grid'] },
                { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
                { name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', '-' ] },
                { name: 'tools', items: [ 'ShowBlocks', 'Maximize', 'Sourcedialog' ] },
                '/',
                { name: 'boostrap5', items: [ 'Templates', '-', 'cols', 'Format',  ] },
                //{ name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
            ]
            */
        });
    });
};

var _replaceCKEditor = () => {
    $('.editor-ck').each(function (index, elem) {
        var height = $(elem).data('height') ? $(elem).data('height') : 500;
        // Assuming CKEditor 4
        CKEDITOR.replace(elem, {
            language                : 'tr',
            startupOutlineBlocks    : true,
            height                  : height,
            format_tags             : 'p;h1;h2;h3;h4;h5;h6;pre',
            removeDialogTabs        : 'image:advanced;link:advanced',
            allowedContent          : true,
            extraPlugins            : 'bootstrap, automodule, bt_table',
            removePlugins           : 'sourcearea',
            contentsCss             : [
                '/plugins/icons/icomoon/style.css',
                '/plugins/editors/ckeditor/custom.css',
            ],
            filebrowserImageBrowseUrl: '/filemanager?type=Images',
            filebrowserImageUploadUrl: '/filemanager/upload?type=Images&_token=',
            filebrowserBrowseUrl: '/filemanager?type=Files',
            filebrowserUploadUrl: '/filemanager/upload?type=Files&_token='
        });

        // After the editor is initialized
        CKEDITOR.instances[elem.id].on('instanceReady', function() {
            // Now you can safely use getData()
            var content = this.getData();
            console.log('Initial Content:', content);

            // If you want to keep track of changes
            this.on('change', function() {
                var updatedContent = this.getData();
                console.log('Updated Content:', updatedContent);
            });
        });
    });
}

var _replaceCKEditorCustom = (class_name) => {
    $('.' + class_name).each(function (index, elem) {
        var height = $(elem).data('height') ? $(elem).data('height') : 500;
        // Assuming CKEditor 4
        CKEDITOR.replace(elem, {
            language                : 'tr',
            startupOutlineBlocks    : true,
            height                  : height,
            format_tags             : 'p;h1;h2;h3;h4;h5;h6;pre',
            removeDialogTabs        : 'image:advanced;link:advanced',
            allowedContent          : true,
            extraPlugins            : 'bootstrap, automodule, bt_table',
            removePlugins           : 'sourcearea',
            contentsCss             : [
                '/plugins/icons/icomoon/style.css',
                '/plugins/editors/ckeditor/custom.css',
            ],
            filebrowserImageBrowseUrl: '/filemanager?type=Images',
            filebrowserImageUploadUrl: '/filemanager/upload?type=Images&_token=',
            filebrowserBrowseUrl: '/filemanager?type=Files',
            filebrowserUploadUrl: '/filemanager/upload?type=Files&_token='
        });

        // After the editor is initialized
        CKEDITOR.instances[elem.id].on('instanceReady', function() {
            // Now you can safely use getData()
            var content = this.getData();
            console.log('Initial Content:', content);

            // If you want to keep track of changes
            this.on('change', function() {
                var updatedContent = this.getData();
                console.log('Updated Content:', updatedContent);
            });
        });
    });
}

var lfmImage = function () {
    $('.lfm-image').each(function (index, elem) {
        $(elem).filemanager('image');
        // if($(elem).parent().children('input').val()) {
        //     var value = $(elem).parent().children('input').val();
        //     var images = value.split(",")
        //     console.log(images)
        // }
    });
}
var lfmFile = function () {
    $('.lfm-file').each(function (index, elem) {
        $(elem).filemanager('file');
    });
}

var fileManagerInput = function (elem) {
    elem.parent().children("img").attr('src', elem.val())
    elem.parent().children("span.input-group-append").children('.button-image-clear').removeClass('d-none')
}


var lfmInput = function (elem) {
    var holder = elem.parent().children("a").attr("data-preview");
    document.getElementById(holder).src = elem.val();
    elem.parent().children("button").removeClass("d-none")
}

var lfmFileInput = function (elem) {
    var holder = elem.parent().children("a").attr("data-preview");
    var content = elem.val();
    if(content) {
        var split = content.split(".");
        document.getElementById(holder).classList.remove("ico-magenta");
        document.getElementById(holder).classList.add("ico-" + split[split.length - 1]);
        setTimeout(function () {
            document.getElementById(holder).innerHTML = '<div class="ico"></div>';
            elem.parent().children("button").removeClass("d-none")
        }, 1);
    }
}

var module_append_res = '' +
    '<li class="box">' +
    '    <div class="sort-icon">\n' +
    '        <i class="bx bx-sort"></i>\n' +
    '    </div>\n' +
    '    <div class="sort-icon">\n' +
    '        <i class="bx bx-edit text-primary" onclick="editModule($(this).parent())"></i>\n' +
    '    </div>\n' +
    '    <div class="input-group overflow-hidden w-full mb-1">\n' +
    '        <select class="select2 form-control mb-1" name="modules[:key][]">:option</select>\n' +
    '    </div>\n' +
    '    <span class="text-danger remove-field cursor-pointer ms-1 pt-2" type="button" onclick="moduleRemove($(this))"><i class="bx bx-x"></i></span>\n' +
    '</li>';

var modulesAdd = function (id) {
    var wrapper    = $(".fields-module-" + id);
    $(wrapper).append(
        module_append_res.replace(':key', id)
            .replace(':option', selectOptions())
    );
    $('.select2').select2();
    drag_drop_all_list();
}

var moduleRemove = function (e) {
    e.parent('li').remove();
}

var editModule = function (e){
    var key = "";

    var options = e.parent().children('.input-group').children('select').children('option');

    for (var i = 0; i < options.length; i++) {
        if(options[i].selected){
            key = options[i].value;
        }
    }
    if(key){
        window.open('/admin/modules/' + key.split(".")[1] + '/edit', '_blank');
    } else {
        alertify.error('Henüz bir modül seçilmediğinden güncelleme yapamazsınız.');
    }
}

var drag_drop_all_list = function (){
    $(".fields-sort").each(function (){
        var id = $(this).attr("id");
        drag_drop_list(document.getElementById(id), 'li');
    })
}

function drag_drop_list(target, tagName = "div") {
    // (A) SET CSS + GET ALL LIST ITEMS
    target.classList.add("slist");
    let items = target.getElementsByTagName(tagName), current = null;

    // (B) MAKE ITEMS DRAGGABLE + SORTABLE
    for (let i of items) {
        // (B1) ATTACH DRAGGABLE
        i.draggable = true;

        // (B2) DRAG START - YELLOW HIGHLIGHT DROPZONES
        i.ondragstart = e => {
            current = i;
            for (let it of items) {
                if (it != current) { it.classList.add("hint"); }
            }
        };

        // (B3) DRAG ENTER - RED HIGHLIGHT DROPZONE
        i.ondragenter = e => {
            if (i != current) { i.classList.add("active"); }
        };

        // (B4) DRAG LEAVE - REMOVE RED HIGHLIGHT
        i.ondragleave = () => i.classList.remove("active");

        // (B5) DRAG END - REMOVE ALL HIGHLIGHTS
        i.ondragend = () => { for (let it of items) {
            it.classList.remove("hint");
            it.classList.remove("active");
        }};

        // (B6) DRAG OVER - PREVENT THE DEFAULT "DROP", SO WE CAN DO OUR OWN
        i.ondragover = e => e.preventDefault();

        // (B7) ON DROP - DO SOMETHING
        i.ondrop = e => {
            e.preventDefault();
            if (i != current) {
                let currentpos = 0, droppedpos = 0;
                for (let it=0; it<items.length; it++) {
                    if (current == items[it]) { currentpos = it; }
                    if (i == items[it]) { droppedpos = it; }
                }
                if (currentpos < droppedpos) {
                    i.parentNode.insertBefore(current, i.nextSibling);
                } else {
                    i.parentNode.insertBefore(current, i);
                }
            }
        };
    }
}

var selectOptions = function () {
    const module_list = JSON.parse(modules);
    var res = "<option value=\"\">Seçiniz</option>";
    module_list.forEach(function (item, index) {
        res += '<optgroup label="' + item.name + '">' + item.name + '</optgroup>';

        var childs = item.children;

        for (var k in childs) {
            res += '<option value="' + item.key + "." + k + '" data-update="' + childs[k]["no_updated"] + '">' + childs[k]["name"] + '</option>';
        }
    })
    return res;
}

setInterval(function () {
    lfmImage();
    lfmFile();
}, 1000)

document.addEventListener('DOMContentLoaded', function() {
    _componentCKEditor();
    lfmImage();
    lfmFile();
    drag_drop_all_list();
});


// module copy
function handleClick() {
    /* Save value of myText to input variable */
    var input = document.getElementById("myText").value;

    /* Copy the text inside the text field */
    navigator.clipboard.writeText(input);

    alert("Copied Text: " + input);
}
function copyToClipboard(element) {
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val($(element).text()).select();
    document.execCommand("copy");
    $temp.remove();
}
var copyText = function (key) {
    const element = document.querySelector('#'+key);
    element.select();
    element.setSelectionRange(0, 99999);
    document.execCommand('copy');
    alertify.success("Kopyalandı");
}

var ModuleModal = function (){
    $("#ModuleModal").modal("show");
}

$(".file-trash").on("click", function (){
    var elem = document.getElementById($(this).attr("data-id"));
    const holder = document.getElementById($(this).attr("data-preview"));
    if (elem) {
        elem.value = "";
        holder.className = "";
        $(this).addClass("d-none")
        setTimeout(function () {
            holder.classList.add("mime-icon");
            holder.innerHTML = '<div class="ico"></div>';
        }, 1);
    }
})

$(".file-trash").each(function (item){
    var input = document.getElementById($(this).attr("data-id"));
    if (input) {
        if (input.value) {
            $(this).removeClass("d-none");
        }
    }
});

$(".img-trash").on("click", function (){
    var elem = document.getElementById($(this).attr("data-id"));
    const holder = document.getElementById($(this).attr("data-preview"));
    if (elem) {
        elem.value = "";
        $(this).addClass("d-none")
        setTimeout(function () {
            holder.src = "/panel/img/placeholder.png";
        }, 1);
    }
})

$(".img-trash").each(function (item){
    var input = document.getElementById($(this).attr("data-id"));
    if (input) {
        if (input.value) {
            $(this).removeClass("d-none");
        }
    }
});
