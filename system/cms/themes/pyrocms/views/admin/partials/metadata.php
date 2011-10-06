<?php if (isset($analytic_visits) OR isset($analytic_views)): ?>
	<?php echo js('jquery/jquery.excanvas.min.js'); ?>
	<?php echo js('jquery/jquery.flot.js'); ?>
<?php endif; ?>

<?php echo js('jquery/jquery-ui.min.js'); ?>
<?php echo js('jquery/jquery.colorbox.min.js'); ?>
<?php echo js('plugins.js'); ?>

<script type="text/javascript">
	var pyro = {};
	var APPPATH_URI			= "<?php echo APPPATH_URI;?>";
	var SITE_URL			= "<?php echo rtrim(site_url(), '/').'/';?>";
	var BASE_URL			= "<?php echo BASE_URL;?>";
	var BASE_URI			= "<?php echo BASE_URI;?>";
	var UPLOAD_PATH			= "<?php echo UPLOAD_PATH;?>";
	var DEFAULT_TITLE		= "<?php echo $this->settings->site_name; ?>";
	var DIALOG_MESSAGE		= "<?php echo lang('global:dialog:delete_message'); ?>";
	pyro.admin_theme_url 	= "<?php echo BASE_URL . $this->admin_theme->path; ?>";
	pyro.apppath_uri		= "<?php echo APPPATH_URI; ?>";
	pyro.base_uri			= "<?php echo BASE_URI; ?>";
</script>

<?php echo js('scripts.js'); ?>
<?php echo css('plugins.css'); ?>
<?php echo css('jquery/colorbox.css'); ?>

<?php echo $template['metadata']; ?>
