
CKEDITOR.plugins.add( 'automodule', {
    requires: 'autocomplete,textmatch',

    init: function( editor ) {
        if(CKEDITOR.config.autoCompleteItems != undefined){
            editor.on( 'instanceReady', function() {
                var config = {};

                function textTestCallback( range ) {
                    if ( !range.collapsed ) {
                        return null;
                    }
                    return CKEDITOR.plugins.textMatch.match( range, matchCallback );
                }

                function matchCallback( text, offset ) {
                    var left = text.slice( 0, offset ),
                        match = left.match( /#[A-z]*$/);

                    if ( !match ) {
                        return null;
                    }
                    return {
                        start: match.index,
                        end: offset
                    };
                }

                config.textTestCallback = textTestCallback;


                function dataCallback( matchInfo, callback ) {
                    var query = matchInfo.query.substring( 1 ).toLowerCase();
                    var suggestions = CKEDITOR.config.autoCompleteItems.filter( function( item ) {
                        var itemName = item.name.toLowerCase();
                        return itemName.indexOf(query) == 0;
                    } );
                    callback( suggestions );
                }

                config.dataCallback = dataCallback;

                config.itemTemplate = '<li data-id="{id}" class="issue-{type}">#{id}: {name}</li>';
                config.outputTemplate = '[module]{code}.{id}[/module]';

                new CKEDITOR.plugins.autocomplete( editor, config );
            } );
        }

    }
} );
