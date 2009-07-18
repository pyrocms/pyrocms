<style type="text/css">
fieldset dl dd label {
	width:8em;
	display:inline-block;
}
fieldset dl dd input, fieldset dl dd textarea {
	width:95%;
}
</style>

    <h2><?=lang('profile_edit') ?></h2>
    
	<?=form_open('edit-profile', array('id'=>'user_edit_profile'));?>
	
	<fieldset><legend><?=lang('profile_personal_section') ?></legend>
		
				
		<dl class="width-half float-left">
			<dt><?=lang('profile_dob') ?></dt>
			<dd>
				<?=lang('profile_dob_day') ?>: <?=form_dropdown('dob_day', $days, $profile->dob_day) ?>
				<?=lang('profile_dob_month') ?>: <?=form_dropdown('dob_month', $months, $profile->dob_month) ?>
				<?=lang('profile_dob_year') ?>: <?=form_dropdown('dob_year', $years, $profile->dob_year) ?>
			</dd>
		</dl>
		
		<dl class="width-half float-right">
			<dt><label for="gender"><?=lang('profile_gender') ?></label></dt>
			<dd><?=form_dropdown('gender', array(''=> 'Not telling', 'm'=>'Male', 'f'=>'Female'), $profile->gender); ?></dd>
		</dl>
			
		<dl class="clear-both">
			<dt>
			
			<dt><label for="bio"><?=lang('profile_bio') ?></label></dt>
			<dd><?=form_textarea(array('name'=>'bio', 'value'=>$profile->bio, 'cols'=>60, 'rows'=>8)); ?></dd>
			
		</dl>
	</fieldset>
	
	<fieldset><legend><?=lang('profile_contact_section') ?></legend>
		<dl>
			<dt><label for="phone"><?=lang('profile_phone') ?></label></dt>
			<dd><?=form_input('phone', $profile->phone); ?></dd>
			
			<dt><label for="mobile"><?=lang('profile_mobile') ?></label></dt>
			<dd><?=form_input('mobile', $profile->mobile); ?></dd>
			
			<dt><?=lang('profile_address') ?></dt>
			<dd>
				<label for="address_line1"><?=lang('profile_address_line1') ?></label> <?=form_input('address_line1', $profile->address_line1); ?><br/>
				<label for="address_line2"><?=lang('profile_address_line2') ?></label> <?=form_input('address_line2', $profile->address_line2); ?><br/>
				<label for="address_line3"><?=lang('profile_address_line3') ?></label> <?=form_input('address_line3', $profile->address_line3); ?><br/>
				<label for="postcode"><?=lang('profile_address_postcode') ?></label> <?=form_input('postcode', $profile->postcode); ?>
			</dd>
		</dl>
	</fieldset>
	
	<fieldset><legend><?=lang('profile_messenger_section') ?></legend>
		<dl>
			<dt><label for="msn_handle"><?=lang('profile_msn_handle') ?></label></dt>
			<dd><?=form_input('msn_handle', $profile->msn_handle); ?></dd>
			
			<dt><label for="aim_handle"><?=lang('profile_aim_handle') ?></label></dt>
			<dd><?=form_input('aim_handle', $profile->aim_handle); ?></dd>
			
			<dt><label for="yim_handle"><?=lang('profile_yim_handle') ?></label></dt>
			<dd><?=form_input('yim_handle', $profile->yim_handle); ?></dd>
			
			<dt><label for="gtalk_handle"><?=lang('profile_gtalk_handle') ?></label></dt>
			<dd><?=form_input('gtalk_handle', $profile->gtalk_handle); ?></dd>
		</dl>
	</fieldset>
	
	<fieldset><legend><?=lang('profile_avatar_section') ?></legend>
		<dl>
			<dt><label for="mobile"><?=lang('profile_gravatar') ?></label></dt>
			<dd><?=form_input('gravatar', $profile->gravatar); ?></dd>
		</dl>
	</fieldset>

	<?=form_submit('', lang('profile_save_btn')); ?>
	
 <?= form_close(); ?>
