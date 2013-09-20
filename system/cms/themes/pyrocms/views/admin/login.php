<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
	<meta charset="utf-8">
	<meta name=viewport content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
	<meta name="robots" content="noindex,nofollow">
	<title><?php echo $this->settings->site_name; ?> - <?php echo lang('login_title');?></title>

	<base href="<?php echo base_url(); ?>"/>
	<meta name="robots" content="noindex, nofollow"/>

	<?php Asset::css(array('build.css')); ?>
	<?php Asset::js('modernizr.min.js'); ?>

	<?php echo Asset::render() ?>
</head>

<body id="login">


	<header class="navbar animated-fast fadeInDown">
		<div class="navbar-header">
			<a class="navbar-brand no-padding" href="<?php echo site_url(); ?>">
				<?php echo Asset::img('logo.png', 'PyroCMS', array('height' => '48px')); ?>
				&nbsp;
				<span class="font-weight-normal">PyroCMS</span>
			</a>
		</div>
	</header>


	<?php $this->load->view('admin/partials/notices') ?>


	<main class="container animated-fast fadeInUp">
	<div class="row-fluid">
	<div class="col-md-3 col-md-offset-4 padding">

		<section class="">

			<?php echo form_open('admin/login', array('id' => 'login', 'class' => 'form margin-top')); ?>

			<div class="form-group">
				<label for="remember-check">Email</label>
				<input type="text" name="email" class="form-control" placeholder="<?php echo lang('global:email'); ?>"/>
			</div>

			<div class="form-group">
				<label for="remember-check">Password</label>
				<input type="password" name="password" class="form-control" placeholder="<?php echo lang('global:password'); ?>"/>
			</div>

			<div class="form-group">
				<label for="remember-check">
					<input type="checkbox" name="remember" id="remember-check" checked />
					<?php echo lang('user:remember'); ?>
				</label>

				<br/>
			
				<button class="btn btn-primary btn-block" type="submit" name="submit" value="<?php echo lang('login_label'); ?>">
					<span><?php echo lang('login_label'); ?></span>
				</button>
			</div>

			<?php echo form_close(); ?>

		</section>

	</div>
	</div>
	</main>

	

	<footer class="navbar navbar-fixed-bottom">
	<center class="container">
		<div class="row-fluid">
		<div class="col-md-3 col-md-offset-4 padding animated-fast fadeInUp">
			Copyright &copy; 2009 - <?php echo date('Y'); ?> PyroCMS LLC 
			<br><span id="version"><?php echo CMS_VERSION.' '.CMS_EDITION; ?></span>
		</div>
		</div>
	</center>
	</footer>


	<?php Asset::js('build.min.js', null, 'deferred'); ?>

	<?php echo Asset::render_js('deferred') ?>

</body>
</html>