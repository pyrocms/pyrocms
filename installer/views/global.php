<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

		<!-- Stylesheets -->
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/reset.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css" type="text/css" />
		<script type="text/javascript">
			var base_url = '<?php echo base_url(); ?>',
				pass_match = ['<?php echo lang('installer.passwords_match'); ?>','<?php echo lang('installer.passwords_dont_match'); ?>'];
		</script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/installer.js"></script>

		<title>PyroCMS Installer</title>
	</head>
	<body>

		<!-- Header -->
		<div id="header">
			<div class="container">
				<img src="<?php echo base_url(); ?>assets/images/logo.png" alt="PyroCMS" />
				<ul id="menu">
					<li><?php echo anchor('', lang('intro'), $this->uri->segment(2, '') == '' ? 'id="current"' : ''); ?></li>
					<li><?php echo anchor('installer/step_1', lang('step1'), $this->uri->segment(2, '') == 'step_1' ? 'id="current"' : ''); ?></li>
					<li><span id="<?php echo $this->uri->segment(2, '') == 'step_2' ? 'current' : '' ?>"><?php echo lang('step2'); ?></span></li>
					<li><span id="<?php echo $this->uri->segment(2, '') == 'step_3' ? 'current' : '' ?>"><?php echo lang('step3'); ?></span></li>
					<li><span id="<?php echo $this->uri->segment(2, '') == 'step_4' ? 'current' : '' ?>"><?php echo lang('step4'); ?></span></li>
					<li><span id="<?php echo $this->uri->segment(2, '') == 'complete' ? 'current' : '' ?>"><?php echo lang('final'); ?></span></li>
				</ul>
			</div>
		</div>

		<!-- Content -->
		<div id="content">
			<div class="container clearfix">

				<!-- Message type 1 (flashdata) -->
				<?php if($this->session->flashdata('message')): ?>
					<ul class="<?php echo ($this->session->flashdata('message_type')) ? $this->session->flashdata('message_type') : 'success'; ?>">
						<li><?php if($this->session->flashdata('message')) { echo $this->session->flashdata('message'); }; ?></li>
					</ul>
				<?php endif; ?>

				<!-- Message type 2 (validation errors) -->
				<?php if ( validation_errors() ): ?>
					<div id="notification">
						<ul class="failure">
							<?php echo validation_errors('<li>', '</li>'); ?>
						</ul>
					</div>
				<?php endif; ?>

				<?php echo $page_output . PHP_EOL; ?>
			</div>
		</div>

	</body>
</html>