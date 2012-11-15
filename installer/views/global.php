<!doctype html>

<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]> <html class="no-js" lang="en"> 		   <![endif]-->

<head>
	<meta charset="utf-8">

	<title>PyroCMS Installer</title>

	<link rel="stylesheet" href="<?= base_url(); ?>assets/css/style.css" type="text/css" />
	
	<!-- Googlelicious -->
	<link href='http://fonts.googleapis.com/css?family=Questrial' rel='stylesheet' type='text/css'>
	
	<script type="text/javascript">
		var base_url = '<?= base_url(); ?>',
		pass_match = ['<?= lang('installer.passwords_match'); ?>','<?= lang('installer.passwords_dont_match'); ?>'];
	</script>

	<script type="text/javascript" src="<?= base_url(); ?>assets/js/jquery.js"></script>
	<script type="text/javascript" src="<?= base_url(); ?>assets/js/jquery.complexify.js"></script>
	<script type="text/javascript" src="<?= base_url(); ?>assets/js/installer.js"></script>

</head>

<body>

	<div id="container">
			
		<div class="topbar">
			<div class="wrapper">
				
			<div id="logo">
				<img src="<?= base_url(); ?>assets/img/logo.png" alt="PyroCMS" />
			</div>
						
			<ul id="lang">
				<li>
					<a href="<?= site_url('installer/change/english'); ?>" title="English">
						<img src="<?= base_url(); ?>assets/img/flags/gb.gif" alt="English" />
					</a>
				</li>
				<li>
					<a href="<?= site_url('installer/change/brazilian'); ?>" title="Brazilian Portuguese">
						<img src="<?= base_url(); ?>assets/img/flags/br.gif" alt="Brazilian Portuguese" />
					</a>
				</li>
			    <li>
					<a href="<?= site_url('installer/change/portuguese'); ?>" title="Portuguese Portugal">
						<img src="<?= base_url(); ?>assets/img/flags/pt.gif" alt="Portuguese Portugal" />
					</a>
				</li>
				<li>
					<a href="<?= site_url('installer/change/dutch'); ?>" title="Dutch">
						<img src="<?= base_url(); ?>assets/img/flags/nl.gif" alt="Dutch" />
					</a>
				</li>
				<li>
					<a href="<?= site_url('installer/change/french'); ?>" title="French">
						<img src="<?= base_url(); ?>assets/img/flags/fr.gif" alt="French" />
					</a>
				</li>
				<li>
					<a href="<?= site_url('installer/change/finnish'); ?>" title="Finnish">
						<img src="<?= base_url(); ?>assets/img/flags/fi.gif" alt="Finnish" />
					</a>
				</li>
				<li>
					<a href="<?= site_url('installer/change/swedish'); ?>" title="Swedish">
						<img src="<?= base_url(); ?>assets/img/flags/se.gif" alt="Swedish" />
					</a>
				</li>
			        <li>
					<a href="<?= site_url('installer/change/polish'); ?>" title="Polish">
						<img src="<?= base_url(); ?>assets/img/flags/pl.gif" alt="Polish" />
					</a>
				</li>
				<li>
					<a href="<?= site_url('installer/change/slovenian'); ?>" title="Slovensko">
						<img src="<?= base_url(); ?>assets/img/flags/si.gif" alt="Slovensko" />
					</a>
				</li>
				<li>
					<a href="<?= site_url('installer/change/spanish'); ?>" title="Spanish">
						<img src="<?= base_url(); ?>assets/img/flags/es.gif" alt="Spànish" />
					</a>
				</li>
				<li>
					<a href="<?= site_url('installer/change/chinese_traditional'); ?>" title="繁體中文">
						<img src="<?= base_url(); ?>assets/img/flags/tw.gif" alt="繁體中文" />
					</a>
				</li>
				<li>
					<a href="<?= site_url('installer/change/russian'); ?>" title="Русский">
						<img src="<?= base_url(); ?>assets/img/flags/ru.gif" alt="Русский" />
					</a>
				</li>
				<li>
					<a href="<?= site_url('installer/change/arabic'); ?>" title="العربية">
						<img src="<?= base_url(); ?>assets/img/flags/ar.gif" alt="العربية" />
					</a>
				</li>
				<li>
					<a href="<?= site_url('installer/change/greek'); ?>" title="Ελληνικά">
						<img src="<?= base_url(); ?>assets/img/flags/el.gif" alt="Greek" />
					</a>
				</li>
				<li>
					<a href="<?= site_url('installer/change/german'); ?>" title="German">
						<img src="<?= base_url(); ?>assets/img/flags/de.gif" alt="German" />
					</a>
				</li>
				<li>
					<a href="<?= site_url('installer/change/lithuanian'); ?>" title="Lithuanian">
						<img src="<?= base_url(); ?>assets/img/flags/lt.gif" alt="Lithuanian" />
					</a>
				</li>
					<li>
					<a href="<?= site_url('installer/change/danish'); ?>" title="Danish">
						<img src="<?= base_url(); ?>assets/img/flags/dk.gif" alt="Danish" />
					</a>
				</li>
				<li>
					<a href="<?= site_url('installer/change/vietnamese'); ?>" title="Tiếng Việt">
						<img src="<?= base_url(); ?>assets/img/flags/vn.gif" alt="Vietnamese" />
					</a>
				</li>
				<li>
					<a href="<?= site_url('installer/change/indonesian'); ?>" title="Indonesian">
						<img src="<?= base_url(); ?>assets/img/flags/id.gif" alt="Indonesian" />
					</a>
				</li>
				<li>
					<a href="<?= site_url('installer/change/hungarian'); ?>" title="Magyar">
						<img src="<?= base_url(); ?>assets/img/flags/hu.gif" alt="Magyar" />
					</a>
				</li>     
				<li>
					<a href="<?= site_url('installer/change/thai'); ?>" title="ไทย">
						<img src="<?= base_url(); ?>assets/img/flags/th.gif" alt="ไทย" />
					</a>
				</li> 	
				<li>
					<a href="<?= site_url('installer/change/italian'); ?>" title="Italian">
						<img src="<?= base_url(); ?>assets/img/flags/it.gif" alt="Italian" />
					</a>
				</li> 
			</ul>
		</div>		
		</div>
		
		<nav id="menu">
			<ul>
				<li><?= anchor('', lang('intro'), $this->uri->segment(2, '') == '' ? 'id="current"' : ''); ?></li>
				<li><span id="<?= $this->uri->segment(2, '') == 'step_1' ? 'current' : '' ?>"><?= lang('step1'); ?></span><span class="sep"></span></li>
				<li><span id="<?= $this->uri->segment(2, '') == 'step_2' ? 'current' : '' ?>"><?= lang('step2'); ?></span><span class="sep"></span></li>
				<li><span id="<?= $this->uri->segment(2, '') == 'step_3' ? 'current' : '' ?>"><?= lang('step3'); ?></span><span class="sep"></span></li>
				<li><span id="<?= $this->uri->segment(2, '') == 'step_4' ? 'current' : '' ?>"><?= lang('step4'); ?></span><span class="sep"></span></li>
				<li><span id="<?= $this->uri->segment(2, '') == 'complete' ? 'current' : '' ?>"><?= lang('final'); ?></span><span class="sep"></span></li>
			</ul>
		</nav>

		<!-- Message type 1 (flashdata) -->
		<?php if($this->session->flashdata('message')): ?>
			<ul class="block-message success <?= ($this->session->flashdata('message_type')) ? $this->session->flashdata('message_type') : 'block-message success'; ?>">
				<li><?php if($this->session->flashdata('message')) { echo $this->session->flashdata('message'); }; ?></li>
			</ul>
		<?php endif; ?>

		<!-- Message type 2 (validation errors) -->
		<?php if (validation_errors()): ?>
			<div id="notification">
				<ul class="block-message error">
					<?= validation_errors('<li>', '</li>'); ?>
				</ul>
			</div>
		<?php endif; ?>

		<?= $page_output.PHP_EOL; ?>

	</div>

</body>
</html>