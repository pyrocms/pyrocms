<!doctype html>

<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]> <html class="no-js" lang="en"> 		   <![endif]-->

<head>
	<meta charset="utf-8">

	<!-- You can use .htaccess and remove these lines to avoid edge case issues. -->
  	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<title>PyroCMS Installer</title>

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css" type="text/css" />

	<!-- Googlelicious -->
	<link href='http://fonts.googleapis.com/css?family=Questrial' rel='stylesheet' type='text/css'>

	<script type="text/javascript">
		var base_url = '<?php echo base_url(); ?>',
				pass_match = ['<?php echo lang('installer.passwords_match'); ?>','<?php echo lang('installer.passwords_dont_match'); ?>'];
	</script>

	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>

	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.complexify.js"></script>

	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/installer.js"></script>
</head>

<body>

	<div id="container">

		<div class="topbar">
			<div class="wrapper">

			<div id="logo">
				<img src="<?php echo base_url(); ?>assets/images/logo.png" alt="PyroCMS" />
			</div>

<ul id="lang">
				<?php foreach($language_nav as $lang => $info):?>
				<li>
					<a href="<?php echo $info['action_url']; ?>" title="<?php echo $info['name']; ?>">
						<img src="<?php echo $info['image_url']; ?>" alt="<?php echo $info['name']; ?>"/>
					</a>
				</li>
				<?php endforeach; ?>
</ul>
		</div>
		</div>

			<nav id="menu">
				<ul>
					<li><?php echo anchor('', lang('intro'), $this->uri->segment(2, '') == '' ? 'id="current"' : ''); ?></li>
					<li><span id="<?php echo $this->uri->segment(2, '') == 'step_1' ? 'current' : '' ?>"><?php echo lang('step1'); ?></span><span class="sep"></span></li>
					<li><span id="<?php echo $this->uri->segment(2, '') == 'step_2' ? 'current' : '' ?>"><?php echo lang('step2'); ?></span><span class="sep"></span></li>
					<li><span id="<?php echo $this->uri->segment(2, '') == 'step_3' ? 'current' : '' ?>"><?php echo lang('step3'); ?></span><span class="sep"></span></li>
					<li><span id="<?php echo $this->uri->segment(2, '') == 'step_4' ? 'current' : '' ?>"><?php echo lang('step4'); ?></span><span class="sep"></span></li>
					<li><span id="<?php echo $this->uri->segment(2, '') == 'complete' ? 'current' : '' ?>"><?php echo lang('final'); ?></span><span class="sep"></span></li>
				</ul>
			</nav>

			<!-- Message type 1 (flashdata) -->
			<?php if($this->session->flashdata('message')): ?>
				<ul class="block-message success <?php echo ($this->session->flashdata('message_type')) ? $this->session->flashdata('message_type') : 'block-message success'; ?>">
					<li><?php if($this->session->flashdata('message')) { echo $this->session->flashdata('message'); }; ?></li>
				</ul>
			<?php endif; ?>

			<!-- Message type 2 (validation errors) -->
			<?php if ( validation_errors() ): ?>
				<div id="notification">
					<ul class="block-message error">
						<?php echo validation_errors('<li>', '</li>'); ?>
					</ul>
				</div>
			<?php endif; ?>

			<!-- Message type 3 (data for the same page load) -->
			<?php if($this->messages): ?>
				<?php foreach (array_keys($this->messages) as $type): ?>
					<ul class="block-message <?php echo ($type) ? $type : 'success'; ?>">
						<?php foreach ($this->messages as $key => $message): ?>
							<?php if ($key === $type): ?>
								<li><?php echo $message; ?></li>
							<?php endif; ?>
						<?php endforeach; ?>
					</ul>
				<?php endforeach; ?>
			<?php endif; ?>

			<?php echo $page_output . PHP_EOL; ?>

	</div>
</body>
</html>
