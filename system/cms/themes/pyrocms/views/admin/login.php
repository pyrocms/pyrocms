<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $this->settings->site_name; ?> - <?php echo lang('login_title');?></title>
	<base href="<?php echo base_url(); ?>" />
	<meta name="robots" content="noindex, nofollow" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<?php Asset::css('login.css'); ?>
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
<body>
	<div id="login-box-container">
		<div id="login-box">
			<h1 id="login-logo">
				<?php echo Asset::img('admin/login-logo.png', lang('login_title'));?>
			</h1>
			<?php $this->load->view('admin/partials/notices') ?>
			<?php echo form_open('admin/login'); ?>
				<ul>
					<li>
						<i class="icon-user input-icon"></i>
						<?php echo form_input(array('name' => 'email', 'placeholder' => lang('email_label'), 'autocorrect' => 'off', 'autocomplete' => 'off', 'autocapitalize' => 'off'));?>
					</li>

					<li>
						<i class="icon-lock input-icon"></i>
						<?php echo form_password(array('name' => 'password', 'placeholder' => lang('password_label'), 'autocorrect' => 'off', 'autocomplete' => 'off', 'autocapitalize' => 'off'));?>
					</li>

					<li>
						<?php echo form_checkbox(array('id' => 'remember', 'class' => 'remember',  'name' => 'remember', 'value'=> 1)); ?>
						<?php echo form_label(lang('user_remember'), 'remember', array('class' => 'remember',)); ?></label>
					</li>

					<li>
						<?php echo form_submit(array('name' => 'submit', 'value' => lang('login_label'), 'class'=>'btn orange'));?>
					</li>
				</ul>
			<?php echo form_close(); ?>
		</div>
		<div id="powered-by">
			<a href="http://pyrocms.com/">&nbsp;
				<!-- <?php echo Asset::img('admin/poweredby.png', lang('powered_by_pyrocms')); ?> -->
			</a>
		</div>
	</div>
</body>
</html>

