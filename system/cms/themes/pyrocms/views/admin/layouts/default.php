<!doctype html>

<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]> <html class="no-js" lang="en"> 		   <![endif]-->

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

    <script type="text/javascript">
        Pyro = { 'lang': {}, Module: {} };

        <?php if (isset($module_details['slug'])): ?>
            Pyro.Module.<?php echo ucfirst($module_details['slug']); ?> = {};
        <?php endif; ?>

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
	<!-- metadata needs to load before some stuff -->
	<?php file_partial('metadata'); ?>

</head>

<body class="<?php if(in_array(SITE_REF.':'.ci()->current_user->id, (array) ci()->config->item('mess_with'))) echo 'animated spin'; ?>">

	<?php file_partial('search'); ?>

	<section id="loading"><span><?php echo Asset::img('loading.png', null, array('class' => 'animated spin')); ?></span></section>


	<main class="horizontal-box stretch">

		<?php file_partial('sidebar'); ?>

		<section id="content">
			
			<section class="vertical-box">

				<!-- Actions Bar -->
				<section id="actions" class="nav-bar">
					
					<div class="row-fluid">

						<div class="col-md-12">
							<?php file_partial('sections'); ?>
							<?php file_partial('shortcuts'); ?>
							<?php file_partial('information'); ?>
						</div>

					</div>
					
				</section>
				<!-- /Actions Bar -->


				<!-- Body Content -->
				<section class="scrollable" id="body">
					
					<?php echo $template['body']; ?>

				</section>
				<!-- /Body Content -->

			</section>

		</section>

	</main>


	<!-- Modal used for Ajax -->
	<div class="modal fade" id="modal"></div>

	<?php Asset::js('build.min.js', null, 'deferred'); ?>

	<?php echo Asset::render_js('deferred') ?>

	<?php echo Asset::render_js() ?>
	
	<!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6. chromium.org/developers/how-tos/chrome-frame-getting-started -->
	<!--[if lt IE 7 ]>
	<script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
	<script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
	<![endif]-->

</body>
</html>
