<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
	<meta charset="utf-8">
	<meta name=viewport content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
	<title><?php echo $this->settings->site_name; ?> - <?php echo lang('login_title');?></title>

	<base href="<?php echo base_url(); ?>"/>
	<meta name="robots" content="noindex, nofollow"/>
 
	<?php Asset::css('animate/animate.min.css'); ?>
	 <?php echo Asset::css('bootstrap/bootstrap.css'); ?>.      
         <?php echo Asset::css('bootstrap/bootstrap-override.css'); ?> 
        <?php echo Asset::css('bootstrap/bootstrap-responsive.css'); ?>
	<?php Asset::css('bootstrap/font-awesome.min.css'); ?>

	<?php Asset::js('jquery/jquery.js'); ?>
	<?php Asset::js('admin/login.js'); ?>
	<?php Asset::js('bootstrap/bootstrap.min.js'); ?>

	<?php echo Asset::render() ?>
</head>

<body id="login-body">

<div   class="login-screen">
	<section id="content">
		<div id="content-body">

			<div class="animated fadeInDown" id="login-logo"></div>
			<?php $this->load->view('admin/partials/notices') ?>
				<?php echo form_open('admin/login'); ?>
				<div class="form_inputs">
					<ul>
						<li>
							<div class="input animated fadeInDown" id="login-un"><input type="text" name="email" placeholder="<?php echo lang('global:email'); ?>"/></div>
						</li>

						<li>
							<div class="input animated fadeInDown" id="login-pw"><input type="password" name="password" placeholder="<?php echo lang('global:password'); ?>"/></div>
						</li>
						<li class="animated fadeInDown" id="login-save" >
							<label for="remember-check" id="login-remember" style="width: 100% ! important;">
								<input type="checkbox" name="remember" id="remember-check" style="style="vertical-align: baseline;""/>
                                                                <label style="display: inline-block; font-size: 12px; margin-top: 3px; vertical-align: sub;"><?php echo lang('user:remember'); ?></label>
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
<div id="login-footer" >
	<div class="wrapper animated fadeInUp" id="login-credits" style=" color: #777777;">
		Copyright &copy; 2012 - <?php echo date('Y'); ?> Xervmon Inc 
		<br><span id="version" style="color: #222222;display: inline-block;text-shadow: 0 1px 0 #444444;"><?php echo CMS_VERSION.' '.CMS_EDITION; ?></span>
	</div>
</div>
</body>
</html>