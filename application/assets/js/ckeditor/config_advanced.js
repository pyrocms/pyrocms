
CKEDITOR.editorConfig = function( config )
{
	config.toolbar = 'PyroAdvanced';
	
	config.toolbar_PyroAdvanced =
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
