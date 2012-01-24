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
				<?php echo $this->parser->parse_string(Settings::get('ckeditor_config'), $this, TRUE); ?>
			};
			pyro.init_ckeditor();

		});
	})(jQuery);
</script>