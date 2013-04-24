<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<!-- Always force latest IE rendering engine & Chrome Frame -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<?php 
		Asset::js('jquery/jquery.js');
		Asset::js('jquery/jquery.js');
		Asset::css('admin/basic_layout.css'); 
		echo Asset::render();
	?>
	
	<!-- metadata needs to load before some stuff -->
	<?php file_partial('metadata'); ?>

	<!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
</head>
<body>
	<?php $this->load->view('admin/partials/notices') ?>
	<?php echo $template['body']; ?>
</body>
</html>
