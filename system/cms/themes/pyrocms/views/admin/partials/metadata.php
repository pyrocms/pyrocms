<?php if (isset($analytic_visits) OR isset($analytic_views)): ?>
	<?php echo js('jquery/jquery.excanvas.min.js'); ?>
	<?php echo js('jquery/jquery.flot.js'); ?>
<?php endif; ?>

<?php echo js('jquery/jquery-ui.min.js'); ?>
<?php echo js('jquery/jquery.colorbox.min.js'); ?>
<?php echo js('codemirror/codemirror.js'); ?>
<?php echo js('codemirror/mode/css/css.js'); ?>
<?php echo js('codemirror/mode/htmlmixed/htmlmixed.js'); ?>
<?php echo js('codemirror/mode/javascript/javascript.js'); ?>
<?php echo js('codemirror/mode/markdown/markdown.js'); ?>
<?php echo js('plugins.js'); ?>

<script type="text/javascript">
	pyro = { 'lang' : {} };
	var APPPATH_URI					= "<?php echo APPPATH_URI;?>";
	var SITE_URL					= "<?php echo rtrim(site_url(), '/').'/';?>";
	var BASE_URL					= "<?php echo BASE_URL;?>";
	var BASE_URI					= "<?php echo BASE_URI;?>";
	var UPLOAD_PATH					= "<?php echo UPLOAD_PATH;?>";
	var DEFAULT_TITLE				= "<?php echo addslashes($this->settings->site_name); ?>";
	// Deprecated
	var DIALOG_MESSAGE				= "<?php echo lang('global:dialog:delete_message'); ?>";
	pyro.admin_theme_url			= "<?php echo BASE_URL . $this->admin_theme->path; ?>";
	pyro.apppath_uri				= "<?php echo APPPATH_URI; ?>";
	pyro.base_uri					= "<?php echo BASE_URI; ?>";
	pyro.lang.remove				= "<?php echo lang('global:remove'); ?>"
	pyro.lang.delete				= "<?php echo lang('global:delete'); ?>"
	pyro.lang.dialog_message 		= DIALOG_MESSAGE;
</script>

<?php echo js('scripts.js'); ?>
<?php echo css('plugins.css'); ?>
<?php echo css('jquery/colorbox.css'); ?>
<?php echo css('codemirror.css'); ?>

<?php if($module_details['sections']): ?>
<style>section#content {margin-top: 170px!important;}</style>
<?php endif; ?>

<?php echo $template['metadata']; ?>
