<h2><?php echo lang('profile_settings') ?></h2>
<?php echo form_open('edit-settings', array('id'=>'user_edit'));?>

<fieldset>
	<legend><?php echo lang('user_details_section') ?></legend>
	<ul>
	<li class="float-left spacer-right">
		<label for="first_name"><?php echo lang('user_first_name') ?></label><br/>
		<?php echo form_input('settings_first_name', $user_settings->first_name); ?>
	</li>
		
	<li>
		<label for="last_name"><?php echo lang('user_last_name') ?></label><br/>
		<?php echo form_input('settings_last_name', $user_settings->last_name); ?>
	</li>
		
	<!-- Removed since email is the identity
	<li class="float-left spacer-right">
		<label for="email"><?php echo lang('user_email') ?></label><br/>
		<?php echo form_input('settings_email', $user_settings->email); ?>
	</li>
	
	<li>
		<label for="confirm_email"><?php echo lang('user_confirm_email') ?></label><br/>
		<?php echo form_input('settings_confirm_email', ''); ?>
	</li>
	-->
	</ul>
</fieldset>

<fieldset>
	<legend><?php echo lang('user_password_section') ?></legend>
	<ul>
	<li class="float-left spacer-right">
		<label for="password"><?php echo lang('user_password') ?></label><br/>
		<?php echo form_password('settings_password'); ?>
	</li>
	
	<li>
		<label for="confirm_password"><?php echo lang('user_confirm_password') ?></label><br/>
		<?php echo form_password('settings_confirm_password'); ?>
	</li>
	</ul>
</fieldset>

<fieldset>
	<legend><?php echo lang('user_other_settings_section') ?></legend>
	<ul>
	<li>
		<label for="settings_lang"><?php echo lang('user_lang') ?></label><br/>
		<?php echo form_dropdown('settings_lang', $languages, $user_settings->lang); ?>
	</li>
	</ul>
</fieldset>
<?php echo form_submit('', lang('user_settings_btn')); ?>
<?php echo form_close(); ?>