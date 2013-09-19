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

	<!-- metadata needs to load before some stuff -->
	<?php file_partial('metadata'); ?>

</head>

<body>

	<main class="horizontal-box stretch">

		<div id="content-body">
			<?php file_partial('notices'); ?>
			<?php echo $template['body']; ?>
		</div>

	</main>

	<footer class="clearfix">
		<div class="wrapper">
			<p class="credits">Copyright &copy;<?php echo date('Y'); ?> PyroCMS LLC &nbsp; <span>Version <?php echo CMS_VERSION.' '.CMS_EDITION; ?> &nbsp; Rendered in {elapsed_time} sec. using {memory_usage}.</span></p>

			<ul id="lang">
				<form action="<?php echo current_url(); ?>" id="change_language" method="get">
					<select class="chzn" name="lang" onchange="this.form.submit();">
						<?php foreach(config_item('supported_languages') as $key => $lang): ?>
							<option value="<?php echo $key; ?>" <?php echo CURRENT_LANGUAGE == $key ? ' selected="selected" ' : ''; ?>>
								 <?php echo $lang['name']; ?>
							</option>
						<?php endforeach; ?>
					</select>
				</form>
			</ul>
		</div>
	</footer>

	<?php Asset::js('build.min.js', null, 'deferred'); ?>

	<?php echo Asset::render_js('deferred') ?>
	
	<!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6. chromium.org/developers/how-tos/chrome-frame-getting-started -->
	<!--[if lt IE 7 ]>
	<script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
	<script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
	<![endif]-->

</body>
</html>
