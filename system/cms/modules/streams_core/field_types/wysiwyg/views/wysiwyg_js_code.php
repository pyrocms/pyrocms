<script type="text/javascript">var SITE_URL	= "<?php echo site_url(); ?>";</script>
<?php 

	if(!defined('ADMIN_THEME')):
	
		$admin_theme = $this->theme_m->get_admin();
		$this->asset->set_theme($admin_theme->slug);
	
	endif;
	
	echo js('ckeditor/ckeditor.js', '_theme_');
	echo js('ckeditor/adapters/jquery.js', '_theme_');

	if(!defined('ADMIN_THEME')) $this->asset->set_theme($this->theme->slug);

?>

<script type="text/javascript">

	var instance;

	function update_instance()
	{
		instance = CKEDITOR.currentInstance;
	}

	(function($) {
		$(function(){

			$('textarea.wysiwyg-simple').ckeditor({
				toolbar: [
					 ['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink']
				  ],
				width: 675,
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
					['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],'/',
					['Format', 'FontSize', 'Subscript','Superscript', 'NumberedList','BulletedList','Outdent','Indent','Blockquote'],
					['ShowBlocks', 'RemoveFormat', 'Source']
				],
				extraPlugins: 'pyroimages,pyrofiles',
				width: 675,
				height: 300,
				dialog_backgroundCoverColor: '#000',
				removePlugins: 'elementspath',
				defaultLanguage: '<?php echo config_item('default_language'); ?>',
				language: '<?php echo CURRENT_LANGUAGE; ?>'
			});

		});
	})(jQuery);
</script>