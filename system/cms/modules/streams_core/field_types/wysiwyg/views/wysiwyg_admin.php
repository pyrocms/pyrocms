<script src="<?php echo Asset::get_filepath_js('../build/js/plugins/ckeditor/ckeditor.js') ?>"></script>
<script src="<?php echo Asset::get_filepath_js('../build/js/plugins/ckeditor/adapters/jquery.js') ?>"></script>

<script type="text/javascript">

	var instance;

	function update_instance()
	{
		instance = CKEDITOR.currentInstance;
	}

	(function($) {
		$(function(){

			Pyro.init_ckeditor = function(){
				<?php echo $this->parser->parse_string(Settings::get('ckeditor_config'), $this, true) ?>
				//Pyro.init_ckeditor_maximize();
			};
			Pyro.init_ckeditor();

		});
	})(jQuery);
</script>
