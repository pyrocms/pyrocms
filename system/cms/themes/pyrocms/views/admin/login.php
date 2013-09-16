<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
	<meta charset="utf-8">
	<meta name=viewport content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
	<meta name="robots" content="noindex,nofollow">
	<title><?php echo $this->settings->site_name; ?> - <?php echo lang('login_title');?></title>

	<base href="<?php echo base_url(); ?>"/>
	<meta name="robots" content="noindex, nofollow"/>

	<?php Asset::css(array('application.css')); ?>
	<?php //Asset::js('jquery/jquery.js'); ?>

	<?php echo Asset::render() ?>
</head>

<body id="white-topo">

	<?php $this->load->view('admin/partials/notices') ?>

	<section class="container">
	<div class="row">
	<div class="col-md-3 col-md-offset-4">

		<section class="background-color-white">

			<center class="background-color-red">
				<?php echo Asset::img('logo.png', 'PyroCMS', array('height' => '48px')); ?>
				&nbsp;
				<span class="color-white font-weight-normal">PyroCMS</span>
			</center>
			
			<?php echo form_open('admin/login', array('class' => 'form margin-top')); ?>

			<div class="form-group color-white">
				<input type="text" name="email" class="form-control" placeholder="<?php echo lang('global:email'); ?>"/>
			</div>

			<div class="form-group color-white">
				<input type="password" name="password" class="form-control" placeholder="<?php echo lang('global:password'); ?>"/>
			</div>

			<div class="form-group color-white">
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


		<center class="animated fadeIn">
			Copyright &copy; 2009 - <?php echo date('Y'); ?> PyroCMS LLC 
			<br><span id="version"><?php echo CMS_VERSION.' '.CMS_EDITION; ?></span>
		</center>


	</div>
	</div>
	</section>

</body>
</html>