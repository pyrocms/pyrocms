<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
	<meta charset="utf-8">
	<meta name=viewport content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
	<meta name="robots" content="noindex,nofollow">
	<title><?php echo $this->settings->site_name; ?> - <?php echo lang('login_title');?></title>

	<base href="<?php echo base_url(); ?>"/>
	<meta name="robots" content="noindex, nofollow"/>

	<?php Asset::css('workless/workless.css'); ?>
	<?php Asset::css('workless/application.css'); ?>
	<?php Asset::css('workless/responsive.css'); ?>
	<?php Asset::css('animate/animate.css'); ?>

	<?php Asset::js('jquery/jquery.js'); ?>
	<?php Asset::js('admin/login.js'); ?>

	<?php echo Asset::render() ?>
</head>

<body id="login-body">

<div id="container" class="login-screen">
	<section id="content">
		<div id="content-body">

			<div class="animated bounceIn" id="login-logo"></div>
			<?php $this->load->view('admin/partials/notices') ?>
				<?php echo form_open('admin/login'); ?>
				<div class="form_inputs">
					<ul>
						<li>
							<div class="input animated fadeIn" id="login-un"><input type="text" name="email" placeholder="<?php echo lang('global:email'); ?>"/></div>
						</li>

						<li>
							<div class="input animated fadeIn" id="login-pw"><input type="password" name="password" placeholder="<?php echo lang('global:password'); ?>"/></div>
						</li>
						<li class="animated fadeIn" id="login-save">
							<label for="remember-check" id="login-remember">
								<input type="checkbox" name="remember" id="remember-check" checked />
								<?php echo lang('user:remember'); ?>
							</label>
						</li>
					</ul>
					<div class="animated fadeIn" id="login-action">
						<div class="buttons padding-top" id="login-buttons">
							<button id="login-submit" class="btn" ontouchstart="" type="submit" name="submit" value="<?php echo lang('login_label'); ?>">
								<span><?php echo lang('login_label'); ?></span>
							</button>
						</div>
					</div>
					<!-- </div> -->
				<?php echo form_close(); ?>
			</div>
		</div>
	</section>
</div>
<footer id="login-footer">
	<div class="wrapper animated fadeIn" id="login-credits">
		Copyright &copy; 2009 - <?php echo date('Y'); ?> PyroCMS LLC 
		<br><span id="version"><?php echo CMS_VERSION.' '.CMS_EDITION; ?></span>
	</div>
</footer>
</body>
</html>