<h1><?php echo lang('header'); ?></h1>

<p><?php echo lang('intro_text'); ?></p>

<?php echo form_open(uri_string(), 'id="install_frm"'); ?>

	<h2><?php echo lang('db_settings'); ?></h2>

	<div class="input">
		<label for="database"><?php echo lang('database'); ?></label>
		<input type="text" id="database" class="input_text" name="database" value="<?php echo set_value('database'); ?>" />
	</div>

	<div class="input">
		<label for="create_db"><?php echo lang('db_create'); ?></label>
		<input type="checkbox" name="create_db" value="true" id="create_db" />
		<small>(<?php echo lang('db_notice'); ?>)</small>
	</div>

	<br />

		<input type="hidden" id="site_ref" name="site_ref" value="default" />

	<h2><?php echo lang('default_user'); ?></h2>

	<div class="input">
		<label for="user_name"><?php echo lang('user_name'); ?></label>
		<?php
			echo form_input(array(
				'id' => 'user_name',
				'name' => 'user_name',
				'value' => set_value('user_name')
			));
		?>
	</div>

	<div class="input">
		<label for="user_firstname"><?php echo lang('first_name'); ?></label>
		<?php
			echo form_input(array(
				'id' => 'user_firstname',
				'name' => 'user_firstname',
				'value' => set_value('user_firstname')
			));
		?>
	</div>

	<div class="input">
		<label for="user_lastname"><?php echo lang('last_name'); ?></label>
		<?php
			echo form_input(array(
				'id' => 'user_lastname',
				'name' => 'user_lastname',
				'value' => set_value('user_lastname')
			));
		?>
	</div>

	<div class="input">
		<label for="user_email"><?php echo lang('email'); ?></label>
		<?php
			echo form_input(array(
				'id' => 'user_email',
				'name' => 'user_email',
				'value' => set_value('user_email')
			));
		?>
	</div>

	<div class="input">
		<label for="user_password"><?php echo lang('password'); ?></label>
		<?php
			echo form_password(array(
				'id' => 'user_password',
				'name' => 'user_password',
				'value' => set_value('user_password')
			));
		?>
	</div>

	<div class="input">
		<label for="user_confirm_password"><?php echo lang('conf_password'); ?></label>
		<?php
			echo form_password(array(
				'id' => 'user_confirm_password',
				'name' => 'user_confirm_password',
				'value' => set_value('user_confirm_password')
			));
		?>
	</div>

	<div id="notification">
	   <p class="text" id="confirm_pass"></p>
	</div>

	<input id="next_step" type="submit" id="submit" value="<?php echo lang('finish'); ?>" />

<?php echo form_close(); ?>