<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title><?php echo $this->settings->item('site_name'); ?> :: Login</title>
		<meta http-equiv="Pragma" content="no-cache" />
		
		<?php $this->load->view('admin/fragments/metadata'); ?>
	</head>
	<body>
		<!-- Content -->
		<div id="login" class="content">
		
			<? if (!empty($this->validation->error_string)): ?>
				<div class="message message-error">
					<h6><?php echo lang('login_error');?></h6>
					<p><?php echo $this->validation->error_string;?></p>
					<a class="close icon icon_close" title="<?php echo lang('close_message');?>" href="#"></a>
				</div>
			<? endif; ?>
			
			<div class="login-box">

				<div id="content-head" class="b2">
					<h2><?php echo lang('login_title');?></h2>
				</div>

				<div id="innerContent">

					<?php echo form_open('admin/login'); ?>	
	
						<div class="field">
							<?php echo lang('email_label', 'email');?>
							<?php echo form_input('email', $this->validation->email); ?>
						</div>
						
						<div class="field">
							<?php echo lang('password_label', 'password');?>
							<?php echo form_password('password', $this->validation->email); ?>
						</div>
						
						<div class="clear-both login-submit">
							<? /* ?><span class="fleft">
								<input type="checkbox" name="remember-me" id="remember-me" />
								<label for="remember-me">Remember me</label>
							</span> */?>
							<span class="float-right">
								<button class="button" type="submit"><strong><?php echo lang('login_label');?></strong></button>
							</span>
						</div>
					
					<?php echo form_close(); ?>

				</div>
				<!-- /Inner Content -->
				<div class="bBottom"><div></div></div>
			</div>
		</div>	
	</body>	
</html>