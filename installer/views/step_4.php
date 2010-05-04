<?php if (validation_errors() OR isset($message)): ?>
<div id="notification" class="error">
	<?php echo validation_errors(); ?>
	<?php echo (isset($message)) ? "<p>$message</p>" : NULL; ?>
</div>
<?php endif; ?>

<h2>Step 4: Create database</h2>
<p>Complete the form below and hit the button labelled "Finish" to install PyroCMS. Be sure to install PyroCMS into the right database since all existing changes will be lost!</p>
<form id="install_frm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<h3>Database Settings</h3>
	<p>
		<label for="database">Database</label>
		<input type="text" id="database" class="input_text" name="database" value="<?php echo set_value('database'); ?>" />
	</p>
	<p>
		<label for="create_db">Create Database</label>
		<input type="checkbox" name="create_db" value="true" id="create_db" />
		<small>(You might need to do this yourself)</small>
	</p>
	<h3>Default User</h3>
	<p>
		<label for="user_name">Username</label>
		<?php echo form_input('user_name', set_value('user_name')); ?>
	</p>
	<p>
		<label for="user_firstname">First name</label>
		<?php echo form_input('user_firstname', set_value('user_firstname')); ?>
	</p>
	<p>
		<label for="user_lastname">Last name</label>
		<?php echo form_input('user_lastname', set_value('user_lastname')); ?>
	</p>
	<p>
		<label for="user_email">Email</label>
		<?php echo form_input('user_email', set_value('user_email')); ?>
	</p>
	<p>
		<label for="user_password">Password</label>
		<?php echo form_password('user_password'); ?>
	</p>
	<p>
		<label for="user_confirm_password">Confirm Password</label>
		<?php echo form_password('user_confirm_password'); ?>
	</p>
	<p id="next_step">
		<input type="submit" id="submit" value="Finish" />
	</p>
	<br class="clear" />
</form>