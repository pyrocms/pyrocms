<style type="text/css">
fieldset dl dd label {
	width:8em;
	display:inline-block;
}
fieldset dl dd input, fieldset dl dd textarea {
	width:95%;
}
</style>

<? if($this->validation->error_string): ?>
<div class="error-box"><?=$this->validation->error_string;?></div>
<? endif; ?>
    <h2><?=lang('profile_settings') ?></h2>
    
	<?=form_open('edit-settings', array('id'=>'user_edit_settings'));?>
	
	<fieldset><legend><?=lang('user_details_section') ?></legend>
		
		<p class="float-left spacer-right">
			<label for="first_name"><?=lang('user_first_name') ?></label><br/>
			<?=form_input('settings_first_name', $user_settings->first_name); ?>
		</p>
		
		<p>
			<label for="last_name"><?=lang('user_last_name') ?></label><br/>
			<?=form_input('settings_last_name', $user_settings->last_name); ?>
		</p>
		
		<p class="float-left spacer-right">
			<label for="email"><?=lang('user_email') ?></label><br/>
			<?=form_input('settings_email', $user_settings->email); ?>
		</p>
		
		<p>
			<label for="confirm_email"><?=lang('user_confirm_email') ?></label><br/>
			<?=form_input('settings_confirm_email', ''); ?>
		</p>
		
	</fieldset>
	
	<fieldset><legend><?=lang('user_password_section') ?></legend>
		
		<p class="float-left spacer-right">
			<label for="password"><?=lang('user_password') ?></label><br/>
			<?=form_password('settings_password'); ?>
		</p>
		
		<p>
			<label for="confirm_password"><?=lang('user_confirm_password') ?></label><br/>
			<?=form_password('settings_confirm_password'); ?>
		</p>

	</fieldset>
	
	<fieldset><legend><?=lang('user_other_settings_section') ?></legend>
		
		<p>
			<label for="settings_lang"><?=lang('user_lang') ?></label><br/>
			<?=form_dropdown('settings_lang', $languages, $user_settings->lang); ?>
		</p>
		
	</fieldset>
	
	<?=form_submit('', lang('user_settings_btn')); ?>
	
 <?= form_close(); ?>
