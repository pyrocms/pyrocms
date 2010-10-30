<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
	<title><?php echo $this->settings->site_name; ?> - <?php echo lang('login_title');?></title>
	<?php echo css('admin/style.css'); ?>
	<?php echo js('jquery/jquery-1.4.2.min.js'); ?>
	<?php echo js('admin/jquery.uniform.min.js'); ?>
	<?php echo js('admin/login.js'); ?>
	
	<!-- Place CSS bug fixes for IE 7 in this comment -->
	<!--[if IE 7]>
	<style type="text/css" media="screen">
		#login-logo { margin: 15px auto 15px auto; }
		.input-email { margin: -24px 0 0 10px;}
		.input-password { margin: -30px 0 0 14px; }
		body#login #login-box input { height: 20px; padding: 10px 4px 4px 35px; }
	</style>
	<![endif]-->

</head>

<body id="login">

<div id="left"></div>
<div id="right"></div>
<div id="top"></div>
<div id="bottom"></div>

	<div id="login-box">
		<header id="main">
			<div id="login-logo"></div>
		</header>
		<?php $this->load->view('admin/partials/notices') ?>
		<?php echo form_open('admin/login'); ?>
			<ul>
				<li>
					<input type="text" name="email" value="Email Address" onblur="if (this.value == '') {this.value = 'Email Address';}"  onfocus="if (this.value == 'Email Address') {this.value = '';}" />
					<img class="input-email" src="<?php echo $base_url;?>system/pyrocms/assets/img/admin/email-icon.png" alt="Email" />
				</li>
				
				<li>
					<input type="password" name="password" value="Enter Password" onblur="if (this.value == '') {this.value = 'Enter Password';}"  onfocus="if (this.value == 'Enter Password') {this.value = '';}"  />
					<img class="input-password" src="<?php echo $base_url;?>system/pyrocms/assets/img/admin/lock-icon.png" alt="Password" />
				</li>
				
				<li><center><input class="button" type="submit" name="submit" value="Login" /></center></li>
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