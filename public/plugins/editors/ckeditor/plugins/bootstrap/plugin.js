( function() {

    CKEDITOR.plugins.add( 'bootstrap', {

        init: function( editor ) {
            editor.addContentsCss( this.path + 'css/style.css' );
            editor.addCommand( 'addRow', new CKEDITOR.dialogCommand( 'addRowDialog' ) );
            editor.addCommand( 'editRow', new CKEDITOR.dialogCommand( 'editRowDialog' ) );
            editor.addCommand( 'removeRow', {
                requiredContent: 'div',
                exec: function( editor ) {
                    var row = CKEDITOR.plugins.bootstrap.getRowElement(editor);
                    if(row){
                        row.remove();
                    }
                }
            } );
            editor.ui.addButton( 'Row', {
                icon: this.path + 'icons/row.png',
                label: 'Create Row',
                command: 'addRow',
                toolbar: 'insert'
            });


            if ( editor.contextMenu ) {
                editor.addMenuGroup( 'rowGroup' );
                editor.addMenuGroup( 'colGroup' );
                editor.addMenuItem( 'rowItem', {
                    label: 'Edit Row',
                    icon: this.path + 'icons/row.png',
                    command: 'editRow',
                    group: 'rowGroup'
                });

                editor.addMenuItem( 'rowRemoveItem', {
                    label: 'Remove Row',
                    icon: this.path + 'icons/row.png',
                    command: 'removeRow',
                    group: 'rowGroup'
                });

                editor.addMenuItem( 'colAddItem', {
                    label: 'Add Col',
                    icon: this.path + 'icons/col.png',
                    command: 'addCol',
                    group: 'colGroup'
                });

                editor.addMenuItem( 'colRemoveItem', {
                    label: 'Delete Col',
                    icon: this.path + 'icons/col.png',
                    command: 'removeCol',
                    group: 'colGroup'
                });



                editor.contextMenu.addListener( function( element ) {
                    if ( !element || element.isReadOnly() )
                        return null;

                    if ( CKEDITOR.plugins.bootstrap.getSurroundRow( editor ) ) {
                        return {
                            rowItem: CKEDITOR.TRISTATE_OFF,
                            rowRemoveItem: CKEDITOR.TRISTATE_OFF,
                            colAddItem: CKEDITOR.TRISTATE_OFF,
                            colRemoveItem: CKEDITOR.TRISTATE_OFF,
                        };
                    }
                    return null;
                });
            }

            editor.addCommand( 'addCol', {
                exec: function( editor ) {
                    var row = CKEDITOR.plugins.bootstrap.getRowElement(editor);
                    if(row){
                        row.appendHtml(CKEDITOR.plugins.bootstrap.template.col);
                    }
                }
            });
            editor.addCommand( 'removeCol', {
                requiredContent: 'div',
                exec: function( editor ) {
                    var col = CKEDITOR.plugins.bootstrap.getColElement(editor);
                    if(col){
                        col.remove();
                    }
                }
            } );
            editor.ui.addButton( 'Col', {
                icon: this.path + 'icons/col.png',
                label: 'Row Add Col',
                command: 'addCol',
                toolbar: 'insert'
            });

            CKEDITOR.dialog.add( 'addRowDialog', this.path + 'dialogs/row.js' );
            CKEDITOR.dialog.add( 'editRowDialog', this.path + 'dialogs/row.js' );
        },



    } );
    CKEDITOR.plugins.bootstrap = {
        template:{
            row:'<div class="{class}">{col}</div>',
            col:'<div class="col"></div>'
        },
        rows:{
            lg:{
                name:'Large',
                default:4,
            },
            md:{
                name:'Medium',
                default:2,
            },
            sm:{
                name:'Small',
                default:1,
            }
        },
        getSurroundRow: function( editor ) {
            var path = editor.elementPath(0);

            for(var i=0;i<path.elements.length;i++) {
                if(path.elements[i].hasClass('row') && !path.elements[i].isReadOnly() ) {
                    return path.elements[i];
                }
            }

        },
        getRowElement:function (editor) {
            var is_find = false;
            $.each(editor.elementPath(0).elements, function (index, element) {
                if(element.hasClass('row') && is_find == false){
                    is_find = element;
                }
            });

            return is_find;
        },
        getColElement:function (editor) {
            var is_find = false;
            $.each(editor.elementPath(0).elements, function (index, element) {
                if(element.hasClass('col') && is_find == false){
                    is_find = element;
                }
            });

            return is_find;
        },
        getRowElements:function (editor) {
            var elements = [];
            $.each(CKEDITOR.plugins.bootstrap.rows, function (key, element) {
                elements.push({
                    id: key,
                    type: 'select',
                    label: element.name,
                    width:'100%',
                    default: element.default,
                    items: [
                        [ editor.lang.common.notSet, '0' ],
                        [ 1, '1' ],
                        [ 2, '2' ],
                        [ 3, '3' ],
                        [ 4, '4' ],
                        [ 5, '5' ],
                        [ 6, '6' ],
                        [ 7, '7' ],
                        [ 8, '8' ],
                        [ 9, '9' ],
                        [ 10, '10' ],
                        [ 11, '11' ],
                        [ 12, '12' ],
                    ],
                    setup: function( element ) {
                        this.setValue( CKEDITOR.plugins.bootstrap.hasRowElementClass(element, key) );
                    }
                })

            })
            return elements;
        },
        hasRowElementClass:function (element, col) {
            for(var i = 1; i <= 12; i++){
                if(element.hasClass('row-cols-' + col + '-' + i)){
                    return i;
                }
            }
            return '';
        },
        getElementClasses:function (dialog) {
            var classes = 'row row-cols-1';

            $.each(CKEDITOR.plugins.bootstrap.rows, function (key, element) {
                var value = dialog.getValueOf( 'info', key );

                if(value){
                    classes += " row-cols-" + key + '-' + value;
                }

            });

            return classes;
        }
    };


} )();
