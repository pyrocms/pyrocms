<style type="text/css">
fieldset dl dd label {
	width:8em;
	display:inline-block;
}
fieldset dl dd input, fieldset dl dd textarea {
	width:95%;
}
</style>

    <h2><?php echo lang('profile_edit') ?></h2>
    
	<?php echo form_open('edit-profile', array('id'=>'user_edit_profile'));?>
	
	<fieldset><legend><?php echo lang('profile_personal_section') ?></legend>
		
				
		<dl class="width-half float-left">
			<dt><?php echo lang('profile_dob') ?></dt>
			<dd>
				<?php echo lang('profile_dob_day') ?>: <?php echo form_dropdown('dob_day', $days, $profile->dob_day) ?>
				<?php echo lang('profile_dob_month') ?>: <?php echo form_dropdown('dob_month', $months, $profile->dob_month) ?>
				<?php echo lang('profile_dob_year') ?>: <?php echo form_dropdown('dob_year', $years, $profile->dob_year) ?>
			</dd>
		</dl>
		
		<dl class="width-half float-right">
			<dt><label for="gender"><?php echo lang('profile_gender') ?></label></dt>
			<dd><?php echo form_dropdown('gender', array(''=> 'Not telling', 'm'=>'Male', 'f'=>'Female'), $profile->gender); ?></dd>
		</dl>
			
		<dl class="clear-both">
			<dt>
			
			<dt><label for="bio"><?php echo lang('profile_bio') ?></label></dt>
			<dd><?php echo form_textarea(array('name'=>'bio', 'value'=>$profile->bio, 'cols'=>60, 'rows'=>8)); ?></dd>
			
		</dl>
	</fieldset>
	
	<fieldset><legend><?php echo lang('profile_contact_section') ?></legend>
		<dl>
			<dt><label for="phone"><?php echo lang('profile_phone') ?></label></dt>
			<dd><?php echo form_input('phone', $profile->phone); ?></dd>
			
			<dt><label for="mobile"><?php echo lang('profile_mobile') ?></label></dt>
			<dd><?php echo form_input('mobile', $profile->mobile); ?></dd>
			
			<dt><?php echo lang('profile_address') ?></dt>
			<dd>
				<label for="address_line1"><?php echo lang('profile_address_line1') ?></label> <?php echo form_input('address_line1', $profile->address_line1); ?><br/>
				<label for="address_line2"><?php echo lang('profile_address_line2') ?></label> <?php echo form_input('address_line2', $profile->address_line2); ?><br/>
				<label for="address_line3"><?php echo lang('profile_address_line3') ?></label> <?php echo form_input('address_line3', $profile->address_line3); ?><br/>
				<label for="postcode"><?php echo lang('profile_address_postcode') ?></label> <?php echo form_input('postcode', $profile->postcode); ?>
			</dd>
		</dl>
	</fieldset>
	
	<fieldset><legend><?php echo lang('profile_messenger_section') ?></legend>
		<dl>
			<dt><label for="msn_handle"><?php echo lang('profile_msn_handle') ?></label></dt>
			<dd><?php echo form_input('msn_handle', $profile->msn_handle); ?></dd>
			
			<dt><label for="aim_handle"><?php echo lang('profile_aim_handle') ?></label></dt>
			<dd><?php echo form_input('aim_handle', $profile->aim_handle); ?></dd>
			
			<dt><label for="yim_handle"><?php echo lang('profile_yim_handle') ?></label></dt>
			<dd><?php echo form_input('yim_handle', $profile->yim_handle); ?></dd>
			
			<dt><label for="gtalk_handle"><?php echo lang('profile_gtalk_handle') ?></label></dt>
			<dd><?php echo form_input('gtalk_handle', $profile->gtalk_handle); ?></dd>
		</dl>
	</fieldset>
	
	<fieldset><legend><?php echo lang('profile_avatar_section') ?></legend>
		<dl>
			<dt><label for="mobile"><?php echo lang('profile_gravatar') ?></label></dt>
			<dd><?php echo form_input('gravatar', $profile->gravatar); ?></dd>
		</dl>
	</fieldset>

	<?php echo form_submit('', lang('profile_save_btn')); ?>
	
 <?php echo form_close(); ?>
