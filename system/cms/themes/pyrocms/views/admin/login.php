<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>

	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	<meta name="author" content="AI Web Systems, Inc. - Ryan Thompson"/>
	

	<!-- Mobile Viewport -->
	<meta name="viewport" content="width=device-width"/>


	<title><?php echo $this->settings->site_name; ?> - <?php echo lang('login_title');?></title>


	<!-- CSS -->
	<?php Asset::css(array('bootstrap.css', 'components.css', 'plugins.css', 'application.css')); ?>
	

	<!--[if lt IE 9]>
		<?php Asset::css('ie.css'); ?>
	<![endif]-->


	<!-- JS -->
	<?php
		
		Asset::js(
			array(
				
				// Application
				'application/jquery.js',
				'application/modernizr.js',
				'application/bootstrap.js',

				// Components
				'components/messenger.js',
				
				// Our customness
				'application/scripts.js',
				)
			);
	?>
	

	<!-- Render -->
	<?php echo Asset::render() ?>

</head>

<body class="login">

<!-- Navbar -->
<div class="navbar navbar-top navbar-inverse navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container-fluid">

			<a class="brand" href="#">aiws</a>

		</div>
	</div>
</div>


<!-- Login Container -->
<div class="container padded">

	<!-- Wrapper -->
	<div class="span4 offset4">

		<?php $this->load->view('admin/partials/notices') ?>

		<!-- Box Styling -->
		<div class="login box animated dropDown">


			<!-- Topbar -->
			<div class="box-header">
				<span class="title">Login</span>
				<ul class="box-toolbar">
					<li class="toolbar-link">
						<a href="#" data-toggle="dropdown"><i class="icon-cog"></i></a>
						<ul class="dropdown-menu">
							<li><a href="#"><i class="icon-question"></i> Forgot Password</a></li>
						</ul>
					</li>
				</ul>
			</div>

			<?php echo form_open('admin/login', 'onsubmit="$(\'.login.box\').removeClass(\'dropDown\').removeClass(\'animated\').addClass(\'animated-zing\').addClass(\'dropUp\');"'); ?>

				<div class="padded">

					<!-- Email -->
					<div class="input-prepend input-append input-block-level">
						<span class="add-on" href="#">
							@
						</span>
						<input type="text" name="email" placeholder="<?php echo lang('global:email'); ?>"/>
					</div>

					<!-- Password -->
					<div class="input-prepend input-append input-block-level">
						<span class="add-on" href="#">
							<i class="icon-key"> </i>
						</span>
						<input class="input-block-level" type="password" name="password" placeholder="<?php echo lang('global:password'); ?>"/>
					</div>

					<!-- Login -->
					<div class="input-block-level">
						<label for="remember-check">
							<input type="checkbox" name="remember" id="remember-check" checked />
							<?php echo lang('user:remember'); ?>
						</label>
					</div>

					<div class="input-block-level">
						<button type="submit" class="btn btn-blue btn-block">
							<?php echo lang('login_label'); ?>
						</button>
					</div>

				</div>

			<?php echo form_close(); ?>

		</div>

	</div>
	
</div>
	
</body>
</html>