<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<!-- Always force latest IE rendering engine & Chrome Frame -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<?php 
		
		Asset::css('plugins.css'); 
		Asset::css('workless/workless.css'); 
		Asset::css('codemirror.css'); 
		Asset::css('animate/animate.css'); 
		Asset::css('admin/basic_layout.css'); 
		Asset::js('jquery/jquery.js');
		Asset::js('jquery/jquery-ui.min.js');
		Asset::js('jquery/jquery.cooki.js');
		Asset::js('jquery/jquery.slugify.js');
		Asset::js('plugins.js');
		Asset::js('scripts.js');
		echo Asset::render();
	?>

	
	<!-- metadata needs to load before some stuff -->
	<?php file_partial('metadata'); ?>

	<!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
</head>
<body style="background: none;">
	<?php $this->load->view('admin/partials/notices') ?>
	<div id="container">
		<section id="content" style="margin-top:0px!important;">
			<div id="content-body">
				<?php echo $template['body']; ?>
			</div>
		</section>
	</div>
</body>
</html>
