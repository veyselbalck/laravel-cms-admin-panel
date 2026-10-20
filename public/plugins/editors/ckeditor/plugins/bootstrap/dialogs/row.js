( function() {
    CKEDITOR.dialog.add( 'addRowDialog', function( editor ) {
        return {
        title: 'Row',
        minWidth: 500,
        minHeight: 100,
        contents: [
            {
                id: 'info',
                elements: CKEDITOR.plugins.bootstrap.getRowElements(editor)
            }
        ],
        onOk: function() {
            var classes = CKEDITOR.plugins.bootstrap.getElementClasses(this);
            var row = CKEDITOR.plugins.bootstrap.template.row;
            row = row.replace('{class}', classes);

            var colCount = Math.max(1, parseInt(this.getValueOf( 'info', 'lg' )));
            var cols = ''
            for(var i = 0; i < colCount; i++){
                cols += CKEDITOR.plugins.bootstrap.template.col;
            }

            row = row.replace('{col}', cols);
            editor.insertHtml( row );
        }
    };
    });
    CKEDITOR.dialog.add( 'editRowDialog', function( editor ) {

        return {
            title: 'Row',
            minWidth: 500,
            minHeight: 100,
            contents: [
                {
                    id: 'info',
                    elements: CKEDITOR.plugins.bootstrap.getRowElements(editor)
                }
            ],
            onShow: function() {
                this.element = CKEDITOR.plugins.bootstrap.getRowElement( editor )
                if(this.element){
                    this.setupContent( this.element );
                }
            },

            onOk: function() {
                if(this.element){
                    var classes = CKEDITOR.plugins.bootstrap.getElementClasses(this);
                    this.element.setAttribute( 'class', classes );
                }
            }
        };
    });
} )();
