/**
 * @license Copyright (c) 2003-2021, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */

// Register a templates definition set named "default".
CKEDITOR.addTemplates( 'default', {
	// The name of sub folder which hold the shortcut preview images of the
	// templates.
	imagesPath: CKEDITOR.getUrl( CKEDITOR.plugins.getPath( 'templates' ) + 'templates/images/' ),

	// The templates definitions.
	templates: [
        {
            title: 'Pdf Icon Download',
            image: 'template4.gif',
            description: '',
            html: '<a href="/" class="d-inline-flex align-items-center align-items-md-end pdf-item"><i class="icon-file-pdf-2 icon-5x text-primary"></i>Lorem Impusum</a>'
        },
	]
} );
