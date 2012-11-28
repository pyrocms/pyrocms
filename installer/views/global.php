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

	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
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
	<li>
		<a href="<?php echo site_url('installer/change/english'); ?>" title="English">
			<img src="<?php echo base_url(); ?>assets/images/flags/gb.gif" alt="English" />
		</a>
	</li>
	<li>
		<a href="<?php echo site_url('installer/change/brazilian'); ?>" title="Brazilian Portuguese">
			<img src="<?php echo base_url(); ?>assets/images/flags/br.gif" alt="Brazilian Portuguese" />
		</a>
	</li>
    <li>
		<a href="<?php echo site_url('installer/change/portuguese'); ?>" title="Portuguese Portugal">
			<img src="<?php echo base_url(); ?>assets/images/flags/pt.gif" alt="Portuguese Portugal" />
		</a>
	</li>
	<li>
		<a href="<?php echo site_url('installer/change/dutch'); ?>" title="Dutch">
			<img src="<?php echo base_url(); ?>assets/images/flags/nl.gif" alt="Dutch" />
		</a>
	</li>
	<li>
		<a href="<?php echo site_url('installer/change/french'); ?>" title="French">
			<img src="<?php echo base_url(); ?>assets/images/flags/fr.gif" alt="French" />
		</a>
	</li>
	<li>
		<a href="<?php echo site_url('installer/change/finnish'); ?>" title="Finnish">
			<img src="<?php echo base_url(); ?>assets/images/flags/fi.gif" alt="Finnish" />
		</a>
	</li>
	<li>
		<a href="<?php echo site_url('installer/change/swedish'); ?>" title="Swedish">
			<img src="<?php echo base_url(); ?>assets/images/flags/se.gif" alt="Swedish" />
		</a>
	</li>
        <li>
		<a href="<?php echo site_url('installer/change/polish'); ?>" title="Polish">
			<img src="<?php echo base_url(); ?>assets/images/flags/pl.gif" alt="Polish" />
		</a>
	</li>
	<li>
		<a href="<?php echo site_url('installer/change/slovenian'); ?>" title="Slovensko">
			<img src="<?php echo base_url(); ?>assets/images/flags/si.gif" alt="Slovensko" />
		</a>
	</li>
	<li>
		<a href="<?php echo site_url('installer/change/spanish'); ?>" title="Spanish">
			<img src="<?php echo base_url(); ?>assets/images/flags/es.gif" alt="Spànish" />
		</a>
	</li>
	<li>
		<a href="<?php echo site_url('installer/change/chinese_traditional'); ?>" title="繁體中文">
			<img src="<?php echo base_url(); ?>assets/images/flags/tw.gif" alt="繁體中文" />
		</a>
	</li>
	<li>
		<a href="<?php echo site_url('installer/change/russian'); ?>" title="Русский">
			<img src="<?php echo base_url(); ?>assets/images/flags/ru.gif" alt="Русский" />
		</a>
	</li>
	<li>
		<a href="<?php echo site_url('installer/change/arabic'); ?>" title="العربية">
			<img src="<?php echo base_url(); ?>assets/images/flags/ar.gif" alt="العربية" />
		</a>
	</li>
	<li>
		<a href="<?php echo site_url('installer/change/greek'); ?>" title="Ελληνικά">
			<img src="<?php echo base_url(); ?>assets/images/flags/el.gif" alt="Greek" />
		</a>
	</li>
	<li>
		<a href="<?php echo site_url('installer/change/german'); ?>" title="German">
			<img src="<?php echo base_url(); ?>assets/images/flags/de.gif" alt="German" />
		</a>
	</li>
	<li>
		<a href="<?php echo site_url('installer/change/lithuanian'); ?>" title="Lithuanian">
			<img src="<?php echo base_url(); ?>assets/images/flags/lt.gif" alt="Lithuanian" />
		</a>
	</li>
		<li>
		<a href="<?php echo site_url('installer/change/danish'); ?>" title="Danish">
			<img src="<?php echo base_url(); ?>assets/images/flags/dk.gif" alt="Danish" />
		</a>
	</li>
	<li>
		<a href="<?php echo site_url('installer/change/vietnamese'); ?>" title="Tiếng Việt">
			<img src="<?php echo base_url(); ?>assets/images/flags/vn.gif" alt="Vietnamese" />
		</a>
	</li>
	<li>
		<a href="<?php echo site_url('installer/change/indonesian'); ?>" title="Indonesian">
			<img src="<?php echo base_url(); ?>assets/images/flags/id.gif" alt="Indonesian" />
		</a>
	</li>
	<li>
		<a href="<?php echo site_url('installer/change/hungarian'); ?>" title="Magyar">
			<img src="<?php echo base_url(); ?>assets/images/flags/hu.gif" alt="Magyar" />
		</a>
	</li>     
	<li>
		<a href="<?php echo site_url('installer/change/thai'); ?>" title="ไทย">
			<img src="<?php echo base_url(); ?>assets/images/flags/th.gif" alt="ไทย" />
		</a>
	</li> 	
	<li>
		<a href="<?php echo site_url('installer/change/italian'); ?>" title="Italian">
			<img src="<?php echo base_url(); ?>assets/images/flags/it.gif" alt="Italian" />
		</a>
	</li> 
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

			<?php echo $page_output . PHP_EOL; ?>

	</div>

</body>
</html>
