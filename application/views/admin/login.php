<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $this->settings->item('site_name'); ?> | <?php echo lang('login_title');?></title>
	<?php echo css('admin/login.css'); ?>

</head>

<body>
	<div id="distance"></div>
	<div id="container">
		<div id="top">
			<h1><?php echo anchor('', $this->settings->item('site_name')); ?></h1>
		</div>
		
		<?php echo form_open('admin/login'); ?>
		<fieldset>
			<legend><?php echo lang('login_title');?></legend>
			<ol>
				<li>
					<label for="email"><?php echo lang('email_label');?>:</label>
					<span><?php echo form_input('email', $this->validation->email); ?></span>
				</li>
				<li>
					<label for="password"><?php echo lang('password_label');?>:</label>
					<span><?php echo form_password('password', $this->validation->password); ?></span>
				</li>
				<li>
					<div class="float-right">
						<input type="image" name="submit" src="<?php echo image_path('admin/bt-login.gif');?>" />
					</div>
				</li>
			</ol>
		</fieldset>
		
		<?php echo form_close(); ?>
	</div>
</body>
</html>