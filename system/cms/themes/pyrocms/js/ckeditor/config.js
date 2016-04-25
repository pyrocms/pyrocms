/**
* @license Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
* For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config ) {
    config.enterMode = CKEDITOR.ENTER_P;
    config.shiftEnterMode = CKEDITOR.ENTER_P;
	config.fillEmptyBlocks = false;
    config.skin = 'moono-dark';
    config.allowedContent = true;
	/* gak pake perubahan entities */
	config.basicEntities = false;
	config.entities = false;
	config.entities_greek = false;
	config.entities_latin = false;
	config.htmlEncodeOutput = false;
	config.entities_processNumerical = false;
	config.clipboard_defaultContentType = 'text';
	/* font setting */
	config.fontSize_defaultLabel = '14px';
};