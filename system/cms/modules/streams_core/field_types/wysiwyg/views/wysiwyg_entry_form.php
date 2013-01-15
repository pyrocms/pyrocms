<script type="text/javascript">var SITE_URL	= "<?php echo site_url() ?>";</script>

<?php 
	$this->admin_theme = $this->theme_m->get_admin();
	Asset::add_path('admin', $this->admin_theme->web_path.'/');
?>

<script type="text/javascript">pyro = {};</script>
<script src="<?php echo Asset::get_filepath_js('admin::ckeditor/ckeditor.js') ?>"></script>
<script src="<?php echo Asset::get_filepath_js('admin::ckeditor/adapters/jquery.js') ?>"></script>

<script type="text/javascript">

	var instance;

	function update_instance()
	{
		instance = CKEDITOR.currentInstance;
	}

	(function($) {
		$(function(){

			pyro.init_ckeditor = function(){
				<?php echo $this->parser->parse_string(Settings::get('ckeditor_config'), $this, true) ?>
				pyro.init_ckeditor_maximize();
			};
			pyro.init_ckeditor();
			
		});
	})(jQuery);
</script>