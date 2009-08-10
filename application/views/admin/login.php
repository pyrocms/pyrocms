<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title><?=$this->settings->item('site_name'); ?> :: Login</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta http-equiv="Expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
		<meta http-equiv="Pragma" content="no-cache" />
		<?=js('jquery/jquery.js') ?>
		<?=css('admin/admin.css').js('admin.js') ?>	
	</head>
	<body>
		<!-- Content -->
		<div id="login" class="content">
		
			<? if (!empty($this->validation->error_string)): ?>
				<div class="message message-error">
					<h6><?=lang('login_error');?></h6>
					<p><?=$this->validation->error_string;?></p>
					<a class="close icon icon_close" title="<?= lang('close_message');?>" href="#"></a>
				</div>
			<? endif; ?>
			
			<div class="roundedBorders login-box">
				<!-- Title -->
				<div id="page-title" class="b2">
					<h2><?= lang('login_title');?></h2>
					<!-- TitleActions -->
					<div id="titleActions">
						<div class="actionBlock">
						<a href="<?=site_url('users/reset_pass'); ?>"><?= lang('forget_password_label');?></a>
						</div>
					</div>
					<!-- /TitleActions -->
				</div>
				<!-- Title -->
		
				<!-- Inner Content -->
				<div id="innerContent">

					<?=form_open('admin/login'); ?>	
	
						<div class="field">
							<label for="username"><?= lang('email_label');?></label>
							<input type="text" class="text" id="email" name="email" value="<?= $this->validation->email; ?>" />
						</div>
						<div class="field">
							<label for="password"><?= lang('password_label');?></label>
							<input type="password" class="text" id="password" name="password" />
						</div>
						<div class="clearfix login-submit">
							<? /* ?><span class="fleft">
								<input type="checkbox" name="remember-me" id="remember-me" />
								<label for="remember-me">Remember me</label>
							</span> */?>
							<span class="fright">
								<button class="button" type="submit"><strong><?= lang('login_label');?></strong></button>
							</span>
						</div>
					
					<?=form_close(); ?>

				</div>
				<!-- /Inner Content -->
				<div class="bBottom"><div></div></div>
			</div>
		</div>	
	</body>	
</html>