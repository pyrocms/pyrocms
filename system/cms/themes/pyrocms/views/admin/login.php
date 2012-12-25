<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
	<meta charset="utf-8">
	<meta name=viewport content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
	<title><?php echo $this->settings->site_name; ?> - <?php echo lang('login_title');?></title>

	<base href="<?php echo base_url(); ?>"/>
	<meta name="robots" content="noindex, nofollow"/>

	<?php Asset::css('workless/workless.css'); ?>
	<?php Asset::css('workless/application.css'); ?>
	<?php Asset::css('workless/responsive.css'); ?>
	<?php Asset::css('animate/animate.min.css'); ?>

	<?php Asset::js('jquery/jquery.js'); ?>
	<?php Asset::js('admin/login.js'); ?>

	<?php echo Asset::render() ?>
</head>

<body>

<div id="container" class="login-screen">
	<section id="content">
		<div id="content-body">

			<?php $this->load->view('admin/partials/notices') ?>
			<div class="animated bounceInDown" id="login-logo"></div>
			<section class="title">
				<h4><?php echo lang('login_title') ?></h4>
			</section>

			<section class="item">
				<div class="content">
					<?php echo form_open('admin/login'); ?>
					<div class="form_inputs">
						<ul>
							<li>
								<!-- <label for="email"><?php echo lang('global:email'); ?></label> -->
								<div class="input"><input type="text" name="email" placeholder="<?php echo lang('global:email'); ?>"/></div>
							</li>
	
							<li>
								<!-- <label for="password"><?php echo lang('global:password'); ?></label> -->
								<div class="input"><input type="password" name="password" placeholder="<?php echo lang('global:password'); ?>"/></div>
							</li>
							<li>
								<label for="remember-check" id="login-remember">
									<input type="checkbox" name="remember" id="remember-check"/>
									<?php echo lang('user:remember'); ?>
								</label>
							</li>
	
						</ul>
						<div id="login-buttons" class="buttons padding-top">
							<button id="login-submit" class="btn green" type="submit" name="submit" value="<?php echo lang('login_label'); ?>">
								<span><?php echo lang('login_label'); ?></span>
							</button>
						</div>
					</div>
					<?php echo form_close(); ?>
				</div>
			</section>
		</div>
	</section>
</div>
<footer>
	<div class="wrapper">
		<p id="login-footer">
			<a href="http://pyrocms.com/" id="login-pyro-link"><?php echo Asset::img('logo.png', 'PyroCMS');?>
				<br><?php echo lang('powered_by_pyrocms') ?></a>
		</p>
	</div>
</footer>
</body>
</html>