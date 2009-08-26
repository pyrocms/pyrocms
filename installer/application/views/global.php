<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		
		<!-- Stylesheets -->
		<link rel="stylesheet" href="<?php echo base_url(); ?>application/assets/css/reset.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>application/assets/css/style.css" type="text/css" />
		
		<title>PyroCMS Installer</title>
	</head>
	<body>
		<!-- Main wrapper -->
		<div id="wrapper">
			<div id="logo">
				<img src="<?php echo base_url(); ?>application/assets/images/logo.png" alt="PyroCMS" width="200" height="76" />
			</div>
			<!-- The header -->
			<div id="header">
				<ul>
					<li><?php echo anchor('', 'Introduction'); ?></li>
					<li><?php echo anchor('installer/step_1', 'Step #1'); ?></li>
					<li><span>Step #2</span></li>
					<li><span>Step #3</span></li>
				</ul>
			</div>
			<!-- The content -->
			<div id="content">
				<?php if($this->session->flashdata('message')): ?>
				<div id="notification" class="<?php if($this->session->flashdata('message_type')){echo $this->session->flashdata('message_type');} ?>">
					<p><?php echo $this->session->flashdata('message'); ?></p>
				</div>
				<?php endif; ?>
				<?php echo $page_output; echo "\n"; ?>
			</div>
		</div>
	</body>
</html>