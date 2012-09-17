<!doctype html>

<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]> <html class="no-js" lang="en"> 		   <![endif]-->

<head>
	<meta charset="utf-8">

	<!-- You can use .htaccess and remove these lines to avoid edge case issues. -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<title><?php echo lang('cp_admin_title').' - '.$template['title'];?></title>

	<base href="<?php echo base_url(); ?>" />

	<!-- Mobile viewport optimized -->
	<meta name="viewport" content="width=device-width,user-scalable=no">

	<!-- metadata needs to load before some stuff -->
	<?php file_partial('metadata'); ?>

</head>

<body>

	<section id="content">
		<?php file_partial('header'); ?>
		<?php file_partial('notices'); ?>
		<div class="wrapper">
			<div id="content-body">
				<?php echo $template['body']; ?>
			</div>
		</div>
	</section>

	<footer>
		<div class="wrapper">
			<div id="pyroinfo">
				<p>&copy; 2009 - <?php echo date('Y'); ?> PyroCMS &nbsp; -- &nbsp; Version <?php echo CMS_VERSION.' '.CMS_EDITION; ?><br>Rendered in {elapsed_time} sec. using {memory_usage}.</p>
			</div>
			<ul id="lang">
				<form action="<?php echo current_url(); ?>" id="change_language" method="get">
					<select class="chzn" name="lang" onchange="this.form.submit();">
						<?php foreach($this->config->item('supported_languages') as $key => $lang): ?>
						<option value="<?php echo $key; ?>" <?php echo CURRENT_LANGUAGE == $key ? 'selected="selected"' : ''; ?>>
								<?php echo $lang['name']; ?>
							</option>
					<?php endforeach; ?>
				</select>
				</form>
			</ul>
		</div>
	</footer>

	<!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6. chromium.org/developers/how-tos/chrome-frame-getting-started -->
	<!--[if lt IE 7 ]>
	<script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
	<script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
	<![endif]-->

</body>
</html>