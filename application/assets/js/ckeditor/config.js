/*
Copyright (c) 2003-2010, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	config.toolbar = 'Pyro';

	config.toolbar_Pyro =
			[
				['Source','-','Preview','-','Undo','Redo','-','Maximize', 'ShowBlocks'],
				['Cut','Copy','Paste','PasteText','PasteFromWord','-','SpellChecker', 'Scayt'],
				['Find','Replace','-','SelectAll','RemoveFormat'],
				['NumberedList','BulletedList','-','Outdent','Indent','Blockquote','CreateDiv'],
				['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
				['Link','Unlink','Anchor'],
				['Image','Flash','Table','HorizontalRule','SpecialChar'],
				['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
				['Styles','Format','Font','FontSize'],
				['TextColor','BGColor'],
			];
	config.skin = 'kama';
};
