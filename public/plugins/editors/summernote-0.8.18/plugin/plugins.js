(function (factory) {
    /* global define */
    if (typeof define === 'function' && define.amd) {
        // AMD. Register as an anonymous module.
        define(['jquery'], factory);
    } else if (typeof module === 'object' && module.exports) {
        // Node/CommonJS
        module.exports = factory(require('jquery'));
    } else {
        // Browser globals
        factory(window.jQuery);
    }
}(function ($) {

    $.extend(true, $.summernote.lang, {
        'en-US': {
            elfinder:{
                tooltip: "Resim Galerisi",
            },
            blocks:{
                title: "Bloklar",
            }
        },
    });

    $.extend($.summernote.options, {
        blocks:[]
    });
    $.extend($.summernote.options.icons, {
        elfinder: "note-icon-picture",
        blocks: "icon-grid",
    });


    // Extends plugins for adding readmore.
    //  - plugin is external module for customizing.
    $.extend($.summernote.plugins, {
        /**
         * @param {Object} context - context object has status of editor.
         */
        'elfinder': function (context) {
            var lang = context.options.langInfo;
            var icons = context.options.icons;
            // ui has renders to build ui elements.
            //  - you can create a button with `ui.button`
            var ui = $.summernote.ui;

            // add elfinder button
            context.memo('button.elfinder', function () {
                // create button
                var button = ui.button({
                    contents: '<i class="'+icons.elfinder+'"></i>',
                    tooltip: lang.elfinder.tooltip,
                    click: function () {
                        window.setUrl = function (files) {
                            context.invoke('editor.insertImage', files.url);
                            Fancybox.close();
                        }

                        Fancybox.defaults.ScrollLock = false;
                        Fancybox.show([
                            {
                                'src': '/elfinder',
                                'type': 'iframe',
                            }
                        ],{
                            'dragToClose' : false
                        });
                    }
                });

                // create jQuery object from button instance.
                var $elfinder = button.render();
                return $elfinder;
            });

            // This methods will be called when editor is destroyed by $('..').summernote('destroy');
            // You should remove elements on `initialize`.
            this.destroy = function () {
                this.$panel.remove();
                this.$panel = null;
            };
        },
        'tableWidth': function (context) {
            var self = this,
                ui = $.summernote.ui,
                $editable = context.layoutInfo.editable;

            context.memo('button.tableWidth', function () {
                return ui.buttonGroup([
                    ui.button({
                        contents: '<b data-width="10">10%<b>', //ui.icon(options.icons.bold),
                        click:function (e) {

                            self.FitCell($(e.target).data('width'));
                        }
                    }),
                    ui.button({
                        contents: '<b data-width="25">25%<b>', //ui.icon(options.icons.bold),
                        click:function (e) {

                            self.FitCell($(e.target).data('width'));
                        }
                    }),
                    ui.button({
                        contents: '<b data-width="33">33%<b>', //ui.icon(options.icons.bold),
                        click:function (e) {

                            self.FitCell($(e.target).data('width'));
                        }
                    }),
                    ui.button({
                        contents: '<b data-width="50">50%<b>', //ui.icon(options.icons.bold),
                        click:function (e) {

                            self.FitCell($(e.target).data('width'));
                        }
                    }),
                ]).render();
            });

            this.FitCell = function (width) {
                const rng = context.invoke('createRange', $editable);
                const dom = $.summernote.dom;
                if (rng.isCollapsed() && rng.isOnCell()) {
                    context.invoke('beforeCommand');
                    var table = dom.ancestor(rng.commonAncestor(), dom.isTable)
                    var $table = $(table);
                    $table.find('td').each(function () {
                        $(this).attr('width', width + '%')
                    });
                    context.invoke('afterCommand');
                }
            };

        },
        'blocks' : function (context) {

            var ui = $.summernote.ui;
            var options = $.summernote.options;
            var blocks  = ui.options.blocks;

            var lang    = options.langInfo;
            var icons   = options.icons;

            var note     = context.layoutInfo.note;

            var data = [];

            context.memo('button.blocks', function () {

                var list = "";
                $(blocks).each(function (index, block) {
                    data[block.id] = block.value;
                    list += '<li data-id="'+block.id+'" class="dropdown-item" href="javascript:;" role="listitem" aria-label="'+block.title+'">'+block.title+'</li>';
                })

                // create button
                var button = ui.buttonGroup([
                    ui.button({
                        className: 'dropdown-toggle',
                        contents: '<i class="'+icons.blocks+' mr-1"></i>' + lang.blocks.title,
                        data: {
                            toggle: 'dropdown'
                        }
                    }),
                    ui.dropdown({
                        contents: list,
                        callback: function ($dropdown) {

                            $dropdown.find('.dropdown-item').each(function () {
                                $(this).click(function () {
                                    var html = data[$(this).data('id')];

                                    //note.summernote('pasteHTML', html);
                                    //context.invoke("editor.insertNode", html);
                                    context.invoke("editor.pasteHTML", html);
                                    //note.summernote('pasteHTML', html);
                                    //context.invoke('editor.insertNode', $(html));
                                });
                            });
                        }
                    })
                ]);

                return button.render();
            });
        }
    });
}));


