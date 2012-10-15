<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $this->settings->site_name; ?> - <?php echo lang('login_title');?></title>
	
	<base href="<?php echo base_url(); ?>" />
	<meta name="robots" content="noindex, nofollow" />

	<?php Asset::css(array('workless/typography.css', 'workless/forms.css', 'workless/buttons.css', 'workless/alerts.css', 'workless/icons.css', 'workless/helpers.css')); ?>
	<?php Asset::css('admin/login.css'); ?>
	<?php Asset::js('jquery/jquery.js'); ?>
	<?php Asset::js('admin/login.js'); ?>
	<?php echo Asset::render() ?>

</head>

<body id="login" class="noise">

	<div class="account-container">
		
		<div class="content clearfix">
			
			<?php echo form_open('admin/login'); ?>
			
				<div id="login-logo"></div>		
						
				<div class="login-fields">
					
					<?php $this->load->view('admin/partials/notices') ?>
					
					<div class="field">
						<input type="text" name="email" placeholder="<?php echo lang('global:email'); ?>" />
						<?php echo Asset::img('admin/email-icon.png', lang('global:email'), array('class' => 'input-email'));?>
					</div> <!-- /field -->
					
					<div class="field">
						<input type="password" name="password" placeholder="<?php echo lang('global:password'); ?>" />
						<?php echo Asset::img('admin/lock-icon.png', lang('global:password'), array('class' => 'input-password'));?>
					</div> <!-- /password -->
					
				</div> <!-- /login-fields -->
				
				<div class="login-actions">
					
					<span class="login-checkbox">
						<input class="remember" class="remember" id="remember" type="checkbox" name="remember" value="1" />
						<label for="remember" class="remember muted"><?php echo lang('user_remember'); ?></label>
					</span>
										
					<button class="button green">Sign In</button>
					
				</div> <!-- .actions -->
				
			<?php echo form_close(); ?>
			
		</div> <!-- /content -->
		
	</div> <!-- /account-container -->
		
</body>
</html>