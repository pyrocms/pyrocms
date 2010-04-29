<style type="text/css">
fieldset dl dd label {
	width:8em;
	display:inline-block;
}
fieldset dl dd input, fieldset dl dd textarea {
	width:95%;
}
</style>
    <h2><?php echo lang('profile_settings') ?></h2>
    
	<?php echo form_open('edit-settings', array('id'=>'user_edit_settings'));?>
	
	<fieldset><legend><?php echo lang('user_details_section') ?></legend>
		
		<p class="float-left spacer-right">
			<label for="first_name"><?php echo lang('user_first_name') ?></label><br/>
			<?php echo form_input('settings_first_name', $user_settings->first_name); ?>
		</p>
		
		<p>
			<label for="last_name"><?php echo lang('user_last_name') ?></label><br/>
			<?php echo form_input('settings_last_name', $user_settings->last_name); ?>
		</p>
		
		<!-- Removed since email is the identity
		<p class="float-left spacer-right">
			<label for="email"><?php echo lang('user_email') ?></label><br/>
			<?php echo form_input('settings_email', $user_settings->email); ?>
		</p>
		
		<p>
			<label for="confirm_email"><?php echo lang('user_confirm_email') ?></label><br/>
			<?php echo form_input('settings_confirm_email', ''); ?>
		</p>
		-->
		
	</fieldset>
	
	<fieldset><legend><?php echo lang('user_password_section') ?></legend>
		
		<p class="float-left spacer-right">
			<label for="password"><?php echo lang('user_password') ?></label><br/>
			<?php echo form_password('settings_password'); ?>
		</p>
		
		<p>
			<label for="confirm_password"><?php echo lang('user_confirm_password') ?></label><br/>
			<?php echo form_password('settings_confirm_password'); ?>
		</p>

	</fieldset>
	
	<fieldset><legend><?php echo lang('user_other_settings_section') ?></legend>
		
		<p>
			<label for="settings_lang"><?php echo lang('user_lang') ?></label><br/>
			<?php echo form_dropdown('settings_lang', $languages, $user_settings->lang); ?>
		</p>
		
	</fieldset>
	
	<?php echo form_submit('', lang('user_settings_btn')); ?>
	
 <?php echo form_close(); ?>
