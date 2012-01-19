<h2 class="page-title" id="page_title"><?php echo lang('user_register_header') ?></h2>

<p>
	<span id="active_step"><?php echo lang('user_register_step1') ?></span> -&gt;
	<span><?php echo lang('user_register_step2') ?></span>
</p>

<?php if ( ! empty($error_string)):?>
<!-- Woops... -->
<div class="error-box">
	<?php echo $error_string;?>
</div>
<?php endif;?>

<?php echo form_open('register', array('id' => 'register')); ?>
<ul>
	<li>
		<label for="first_name"><?php echo lang('user_first_name') ?></label>
		<input type="text" name="first_name" maxlength="40" value="<?php echo $_user->first_name; ?>" />
	</li>
	
	<li>
		<label for="last_name"><?php echo lang('user_last_name') ?></label>
		<input type="text" name="last_name" maxlength="40" value="<?php echo $_user->last_name; ?>" />
	</li>
	
	<?php if ( ! Settings::get('auto_username')): ?>
	<li>
		<label for="username"><?php echo lang('user_username') ?></label>
		<input type="text" name="username" maxlength="100" value="<?php echo $_user->username; ?>" />
	</li>
	<?php endif; ?>
	
	<li>
		<label for="email"><?php echo lang('user_email') ?></label>
		<input type="text" name="email" maxlength="100" value="<?php echo $_user->email; ?>" />
		<?php echo form_input('d0ntf1llth1s1n', ' ', 'class="default-form" style="display:none"'); ?>
	</li>
	
	<li>
		<label for="password"><?php echo lang('user_password') ?></label>
		<input type="password" name="password" maxlength="100" />
	</li>
	
	<li>
		<?php echo form_submit('btnSubmit', lang('user_register_btn')) ?>
	</li>
</ul>
<?php echo form_close(); ?>