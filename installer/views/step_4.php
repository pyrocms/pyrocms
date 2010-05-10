<?php if (validation_errors() OR isset($message)): ?>
<div id="notification" class="error">
	<p>
	<?php echo validation_errors(); ?>
	<?php echo (isset($message)) ? $message : NULL; ?>
	</p>
</div>
<?php endif; ?>

<h2><?php echo lang('header'); ?></h2>
<p><?php echo lang('intro_text'); ?></p>
<form id="install_frm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<h3><?php echo lang('db_settings'); ?></h3>
	<p>
		<label for="database"><?php echo lang('database'); ?></label>
		<input type="text" id="database" class="input_text" name="database" value="<?php echo set_value('database'); ?>" />
	</p>
	<p>
		<label for="create_db"><?php echo lang('db_create'); ?></label>
		<input type="checkbox" name="create_db" value="true" id="create_db" />
		<small>(<?php echo lang('db_notice'); ?>)</small>
	</p>
	<h3><?php echo lang('default_user'); ?></h3>
	<p>
		<label for="user_name"><?php echo lang('user_name'); ?></label>
		<?php echo form_input('user_name', set_value('user_name')); ?>
	</p>
	<p>
		<label for="user_firstname"><?php echo lang('first_name'); ?></label>
		<?php echo form_input('user_firstname', set_value('user_firstname')); ?>
	</p>
	<p>
		<label for="user_lastname"><?php echo lang('last_name'); ?></label>
		<?php echo form_input('user_lastname', set_value('user_lastname')); ?>
	</p>
	<p>
		<label for="user_email"><?php echo lang('email'); ?></label>
		<?php echo form_input('user_email', set_value('user_email')); ?>
	</p>
	<p>
		<label for="user_password"><?php echo lang('password'); ?></label>
		<?php echo form_password('user_password'); ?>
	</p>
	<p>
		<label for="user_confirm_password"><?php echo lang('conf_password'); ?></label>
		<?php echo form_password('user_confirm_password'); ?>
	</p>
	<p id="next_step">
		<input type="submit" id="submit" value="<?php echo lang('finish'); ?>" />
	</p>
	<br class="clear" />
</form>