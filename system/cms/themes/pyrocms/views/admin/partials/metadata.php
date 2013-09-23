<?php //Asset::js(array()) ?>

<?php Asset::css(array('build.css')); ?>
<?php Asset::js('modernizr.min.js'); ?>


<?php if (isset($analytic_visits) OR isset($analytic_views)): ?>
	<?php //Asset::js('jquery/jquery.excanvas.min.js') ?>
	<?php //Asset::js('jquery/jquery.flot.js') ?>
<?php endif; ?>

<script type="text/javascript">
	pyro = { 'lang' : {} };
	var APPPATH_URI					= "<?php echo APPPATH_URI;?>";
	var SITE_URL					= "<?php echo rtrim(site_url(), '/').'/';?>";
	var BASE_URL					= "<?php echo BASE_URL;?>";
	var BASE_URI					= "<?php echo BASE_URI;?>";
	var UPLOAD_PATH					= "<?php echo UPLOAD_PATH;?>";
	var DEFAULT_TITLE				= "<?php echo addslashes(Settings::get('site_name')); ?>";
	pyro.admin_theme_url			= "<?php echo BASE_URL . ci()->theme->path; ?>";
	pyro.apppath_uri				= "<?php echo APPPATH_URI; ?>";
	pyro.base_uri					= "<?php echo BASE_URI; ?>";
	pyro.lang.remove				= "<?php echo lang('global:remove'); ?>";
	pyro.lang.dialog_message 		= "<?php echo lang('global:dialog:delete_message'); ?>";
	pyro.csrf_cookie_name			= "<?php echo config_item('cookie_prefix').config_item('csrf_cookie_name'); ?>";
</script>

<?php echo Asset::render() ?>

<!--[if lt IE 9]>
<?php echo Asset::css('ie.css', null, 'ie'); ?>
<?php echo Asset::render_css('ie'); ?>
<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<?php echo $template['metadata'] ?>
