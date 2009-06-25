<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<!-- Main template for the PyroCMS website : http://www.pyrocms.com/ Please refrain from using this template yourself, else we'll be forced to send a few 4Chan freaks to your house ;] -->
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
		<!-- Main wrapper -->
		<div id="wrapper">
			<!-- Header -->
			<div id="header">
				<?php echo "\n"; $this->load->view($theme_view_folder.'header'); echo "\n"; ?>
			</div>
			<!-- Flash data messages will appear below -->
			<?php if ($this->session->flashdata('notice')) {
		                  echo '<div class="notice notification_box"><p>' . strip_tags($this->session->flashdata('notice')) . '</p></div>';
			}
			if ($this->session->flashdata('success')) {
		                  echo '<div class="success notification_box"><p>' . strip_tags($this->session->flashdata('success')) . '</p></div>';
			}
			if ($this->session->flashdata('error')) {
		                  echo '<div class="error notification_box"><p>' . strip_tags($this->session->flashdata('error')) . '</p></div>';
			}
			?>

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
