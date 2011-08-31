<?php
echo js('ckeditor/ckeditor.js') . PHP_EOL;
echo js('ckeditor/adapters/jquery.js');

$supported_langs = config_item('supported_languages');
$ck_default_lang = config_item('default_language');
$ck_language = empty($supported_langs[CURRENT_LANGUAGE]['ckeditor']) ? CURRENT_LANGUAGE : $supported_langs[CURRENT_LANGUAGE]['ckeditor'];
unset($supported_langs);
?>
<script type="text/javascript">

	var instance;

	function update_instance()
	{
		instance = CKEDITOR.currentInstance;
	}

	(function($) {
		$(function(){

			pyro.init_ckeditor = function(){
				$('textarea.wysiwyg-simple').ckeditor({
					toolbar: [
						 ['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink']
					  ],
					width: '99%',
					height: 100,
					dialog_backgroundCoverColor: '#000',
					defaultLanguage: '<?php echo $ck_default_lang; ?>',
					language: '<?php echo $ck_language; ?>'
				});
	
				$('textarea.wysiwyg-advanced').ckeditor({
					toolbar: [
						['Maximize'],
						['pyroimages', 'pyrofiles'],
						['Cut','Copy','Paste','PasteFromWord'],
						['Undo','Redo','-','Find','Replace'],
						['Link','Unlink'],
						['Table','HorizontalRule','SpecialChar'],
						['Bold','Italic','StrikeThrough'],
						['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
						['Format', 'FontSize', 'Subscript','Superscript', 'NumberedList','BulletedList','Outdent','Indent','Blockquote'],
						['ShowBlocks', 'RemoveFormat', 'Source']
					],
					extraPlugins: 'pyroimages,pyrofiles',
					width: '99%',
					height: 400,
					dialog_backgroundCoverColor: '#000',
					removePlugins: 'elementspath',
					defaultLanguage: '<?php echo $ck_default_lang; ?>',
					language: '<?php echo $ck_language; ?>'
				});
			};
			pyro.init_ckeditor();

		});
	})(jQuery);
</script>