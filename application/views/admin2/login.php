<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $this->settings->item('site_name'); ?> - <?php echo lang('login_title');?></title>
	<?php echo css('admin2/style.css'); ?>
	<?php echo js('jquery/jquery.js'); ?>
	<?php echo js('admin2/jquery.uniform.min.js'); ?>
	<?php echo js('admin2/login.js'); ?>

</head>

<body id="login">
<div id="login-box">
		<header id="main">
			<div id="logo"></div>
			<h1><?php echo $this->settings->item('site_name'); ?></h1>
		</header>
		<?php $this->load->view('admin2/partials/notices') ?>
		<?php echo form_open('admin/login'); ?>
			<ul>
				<li>
					<label for="email"><?php echo lang('email_label');?>:</label>
					<?php echo form_input('email', set_value('email')); ?>
				</li>
				<li>
					<label for="password"><?php echo lang('password_label');?>:</label>
					<?php echo form_password('password'); ?>
				</li>
				<li>
					<label for="nothing"></label>
					<input class="button" type="submit" name="submit" value="Login" />
				</li>
			</ul>
		<?php echo form_close(); ?>
</div>
</body>
</html>