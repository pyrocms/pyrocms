<?php if (validation_errors() OR isset($message)): ?>
<div id="notification" class="error">
	<p>
	<?php echo validation_errors(); ?>
	<?php echo (isset($message)) ? $message : NULL; ?>
	</p>
</div>
<?php endif; ?>

<h2>{header}</h2>
<p>{intro_text}</p>
<form id="install_frm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<h3>{db_settings}</h3>
	<p>
		<label for="database">{database}</label>
		<input type="text" id="database" class="input_text" name="database" value="<?php echo set_value('database'); ?>" />
	</p>
	<p>
		<label for="create_db">{db_create}</label>
		<input type="checkbox" name="create_db" value="true" id="create_db" />
		<small>({db_notice})</small>
	</p>
	<h3>{default_user}</h3>
	<p>
		<label for="user_name">{user_name}</label>
		<?php echo form_input('user_name', set_value('user_name')); ?>
	</p>
	<p>
		<label for="user_firstname">{first_name}</label>
		<?php echo form_input('user_firstname', set_value('user_firstname')); ?>
	</p>
	<p>
		<label for="user_lastname">{last_name}</label>
		<?php echo form_input('user_lastname', set_value('user_lastname')); ?>
	</p>
	<p>
		<label for="user_email">{email}</label>
		<?php echo form_input('user_email', set_value('user_email')); ?>
	</p>
	<p>
		<label for="user_password">{password}</label>
		<?php echo form_password('user_password'); ?>
	</p>
	<p>
		<label for="user_confirm_password">{conf_password}</label>
		<?php echo form_password('user_confirm_password'); ?>
	</p>
	<p id="next_step">
		<input type="submit" id="submit" value="{install}" />
	</p>
	<br class="clear" />
</form>