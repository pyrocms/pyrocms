<script type="text/javascript">var SITE_URL	= "<?php echo site_url(); ?>";</script>

<script src="<?php echo Asset::get_filepath_js('ckeditor/ckeditor.js'); ?>"></script>
<script src="<?php echo Asset::get_filepath_js('ckeditor/adapters/jquery.js'); ?>"></script>
<?php 

	if(!defined('ADMIN_THEME')):
	
		$admin_theme = $this->theme_m->get_admin();
		$this->asset->set_theme($admin_theme->slug);
	
	endif;

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

			pyro.init_ckeditor = function(){
				<?php echo $this->parser->parse_string(Settings::get('ckeditor_config'), $this, TRUE); ?>
			};
			pyro.init_ckeditor();
			
		});
	})(jQuery);
</script>