<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $this->settings->site_name; ?> - <?php echo lang('login_title');?></title>
	
	<base href="<?php echo base_url(); ?>" />
	<meta name="robots" content="noindex, nofollow" />
	
	<?php echo theme_css('admin/style.css'); ?>
	<?php echo theme_js('jquery/jquery.min.js'); ?>
	<?php echo theme_js('admin/login.js'); ?>
	
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
					<input type="text" name="email" value="<?php echo lang('email_label'); ?>" onblur="if (this.value == '') {this.value = '<?php echo lang('email_label'); ?>';}"  onfocus="if (this.value == '<?php echo lang('email_label'); ?>') {this.value = '';}" />
					<?php echo theme_image('admin/email-icon.png', array('class' => 'input-email', 'alt' => lang('email_label')));?>
				</li>
				
				<li>
					<input type="password" name="password" value="<?php echo lang('password_label'); ?>" onblur="if (this.value == '') {this.value = '<?php echo lang('password_label'); ?>';}"  onfocus="if (this.value == '<?php echo lang('password_label'); ?>') {this.value = '';}"  />
					<?php echo theme_image('admin/lock-icon.png', array('class' => 'input-password', 'alt' => lang('password_label')));?>
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