<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $this->settings->site_name; ?> - <?php echo lang('login_title');?></title>
	
	<base href="<?php echo base_url(); ?>" />
	<meta name="robots" content="noindex, nofollow" />
	
	<?php Asset::css('admin/style.css'); ?>
	<?php Asset::js('jquery/jquery.js'); ?>
	<?php Asset::js('admin/login.js'); ?>
	
	<?php echo Asset::render() ?>
	
	<!-- Place CSS bug fixes for IE 7 in this comment -->
	<!--[if IE 7]>
	<style type="text/css" media="screen">
		#login-logo { margin: 15px auto 15px auto; }
		.input-email { margin: -24px 0 0 10px;}
		.input-password { margin: -30px 0 0 14px; }
		body#login #login-box input { height: 20px; padding: 10px 4px 4px 35px; }
		body#login{ margin-top: 14%;}
	</style>
	<![endif]-->

</head>

<body id="login">

<div id="left"></div>
<div id="right"></div>
<div id="top"></div>
<div id="bottom"></div>

	<div id="login-box">
		
		<?php $this->load->view('admin/partials/notices') ?>
		
		<header id="main">
			<div id="login-logo"></div>
		</header>
		
		<?php echo form_open('admin/login'); ?>
			<ul>
				<li>
					<input type="text" name="email" placeholder="<?php echo lang('email_label'); ?>" />
					<?php echo Asset::img('admin/email-icon.png', lang('email_label'), array('class' => 'input-email'));?>
				</li>
				
				<li>
					<input type="password" name="password" placeholder="<?php echo lang('password_label'); ?>"  />
					<?php echo Asset::img('admin/lock-icon.png', lang('password_label'), array('class' => 'input-password'));?>
				</li>
				
				<li>
					<input class="remember" class="remember" id="remember" type="checkbox" name="remember" value="1" />
					<label for="remember" class="remember"><?php echo lang('user_remember'); ?></label>
				</li>
				
				<li><center><input class="button" type="submit" name="submit" value="<?php echo lang('login_label'); ?>" /></center></li>
			</ul>
		<?php echo form_close(); ?>
	</div>
	<center>
		<ul id="login-footer">
			<li><a href="http://pyrocms.com/">Powered by PyroCMS</a></li>
		</ul>
	</center>
</body>
</html>