<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">

	<!-- You can use .htaccess and remove these lines to avoid edge case issues. -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<title><?php echo $template['title'].' - '.lang('cp:admin_title') ?></title>

	<base href="<?php echo base_url(); ?>" />

	<!-- Mobile viewport optimized -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

	<!-- Load up some favicons -->
	<link rel="shortcut icon" href="favicon.ico">
	<link rel="apple-touch-icon" href="apple-touch-icon.png">
	<link rel="apple-touch-icon" href="apple-touch-icon-precomposed.png">
	<link rel="apple-touch-icon" href="apple-touch-icon-57x57-precomposed.png">
	<link rel="apple-touch-icon" href="apple-touch-icon-72x72-precomposed.png">
	<link rel="apple-touch-icon" href="apple-touch-icon-114x114-precomposed.png">

	<!-- metadata needs to load before some stuff -->
	<?php file_partial('metadata'); ?>
</head>
<body>
	
	<?php $this->load->view('admin/partials/notices') ?>
	
	<?php echo $template['body']; ?>

    <script type="text/javascript">
        Pyro = { 'lang': {} };

        var APPPATH_URI					= "<?php echo APPPATH_URI;?>";
        var SITE_URL					= "<?php echo rtrim(site_url(), '/').'/';?>";
        var BASE_URL					= "<?php echo BASE_URL;?>";
        var BASE_URI					= "<?php echo BASE_URI;?>";
        var UPLOAD_PATH					= "<?php echo UPLOAD_PATH;?>";
        var DEFAULT_TITLE				= "<?php echo addslashes(Settings::get('site_name')); ?>";
        Pyro.current_module				= "<?php echo isset($module_details['slug']) ? $module_details['slug'] : null; ?>";
        Pyro.admin_theme_url			= "<?php echo BASE_URL . ci()->theme->path; ?>";
        Pyro.apppath_uri				= "<?php echo APPPATH_URI; ?>";
        Pyro.base_uri					= "<?php echo BASE_URI; ?>";
        Pyro.lang.remove				= "<?php echo lang('global:remove'); ?>";
        Pyro.lang.dialog_message 		= "<?php echo lang('global:dialog:delete_message'); ?>";
        Pyro.csrf_cookie_name			= "<?php echo config_item('cookie_prefix').config_item('csrf_cookie_name'); ?>";
    </script>

	<?php Asset::js('build.min.js', null, 'deferred'); ?>

	<?php echo Asset::render_js('deferred') ?>

</body>
</html>
