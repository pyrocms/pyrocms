<?php 
Asset::js('ckeditor/ckeditor_source.js', 'ckeditor/ckeditor.js', 'wysiwyg');
Asset::js('ckeditor/adapters/jquery.js', NULL, 'wysiwyg'); 
echo Asset::render_js('wysiwyg') ?>

<script type="text/javascript">

	var instance;

	function update_instance()
	{
		instance = CKEDITOR.currentInstance;
	}

	(function($) {
		$(function(){

			pyro.init_ckeditor = function(){
				<?php echo $this->parser->parse_string(Settings::get('ckeditor_config'), $this, TRUE); ?>
			};
			pyro.init_ckeditor();

		});
	})(jQuery);
</script>