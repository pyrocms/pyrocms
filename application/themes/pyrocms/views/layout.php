<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<!-- Find the hidden easter eggs ! -->
		<!-- Meta information -->
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<?php echo "\n"; echo $extra_head_content; ?>
		
		<!-- Stylesheets -->
		<link href="<?php echo base_url(); ?>application/themes/pyrocms/css/reset.css" rel="stylesheet" media="screen" type="text/css" />
		<link href="<?php echo base_url(); ?>application/themes/pyrocms/css/style.css" rel="stylesheet" media="screen" type="text/css" />
		<!-- Javascript -->
		
		<title><?php echo $this->settings->item('site_name'); ?></title>		
	</head>
	<body>
		<!-- We shit on CakePHP -->
		<!-- Main wrapper -->
		<div id="wrapper">
			<!-- Header -->
			<div id="header">
				<?php echo "\n"; $this->load->view($theme_view_folder.'header'); echo "\n"; ?>
			</div>
			<!-- Content -->
			<div id="content">
				<?php echo $page_output; ?>
				<div class="clear"></div>
			</div>
			
			<!-- Footer -->
			<div id="footer">
				<?php $this->load->view($theme_view_folder.'footer'); ?>
			</div>
		</div>
		<!-- End of wrapper -->
	</body>
</html>
