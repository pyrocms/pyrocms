<?php echo js('ckeditor/ckeditor.js'); ?>
<?php echo js('ckeditor/adapters/jquery.js'); ?>

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
					defaultLanguage: '<?php echo config_item('default_language'); ?>',
					language: '<?php echo CURRENT_LANGUAGE; ?>'
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
					defaultLanguage: '<?php echo config_item('default_language'); ?>',
					language: '<?php echo CURRENT_LANGUAGE; ?>'
				});
			};
			pyro.init_ckeditor();

		});
	})(jQuery);
</script>