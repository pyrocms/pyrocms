<div id="user_edit_profile">
	<h2 id="page_title"><?php echo lang('profile_edit') ?></h2>

	<?php if(validation_errors()):?>
	<div class="error_box">
		<?php echo validation_errors();?>
	</div>
	<?php endif;?>
   
	<?php echo form_open('edit-profile', array('id'=>'user_edit_profile'));?>

	<fieldset id="user_personal">
		<legend><?php echo lang('profile_personal_section') ?></legend>
		<p>
			<label for="display_name"><?php echo lang('profile_display_name') ?></label>
			<?php echo form_input('display_name', set_value('display_name', $profile->display_name)); ?>
		</p>
			
		<p>
			<?php echo lang('profile_dob') ?>
			<?php echo lang('profile_dob_day') ?>: <?php echo form_dropdown('dob_day', $days, $profile->dob_day) ?>
			<?php echo lang('profile_dob_month') ?>: <?php echo form_dropdown('dob_month', $months, $profile->dob_month) ?>
			<?php echo lang('profile_dob_year') ?>: <?php echo form_dropdown('dob_year', $years, $profile->dob_year) ?>
		
		</p>
	
		<p>
			<label for="gender"><?php echo lang('profile_gender') ?></label>
			<?php echo form_dropdown('gender', array(''=> 'Not telling', 'm'=>'Male', 'f'=>'Female'), $profile->gender); ?>
		</p>
		
		<p>
			<label for="bio"><?php echo lang('profile_bio') ?></label>
			<?php echo form_textarea(array('name'=>'bio', 'value'=>$profile->bio, 'cols'=>60, 'rows'=>8)); ?>
		
		</p>
	</fieldset>

	<fieldset id="user_contact">
		<legend><?php echo lang('profile_contact_section') ?></legend>
		<p>
			<label for="phone"><?php echo lang('profile_phone') ?></label>
			<?php echo form_input('phone', $profile->phone); ?>
		</p>	
		<p>
			<label for="mobile"><?php echo lang('profile_mobile') ?></label>
			<?php echo form_input('mobile', $profile->mobile); ?>
		</p>
		<p>
			<label for="address_line1"><?php echo lang('profile_address_line1') ?></label> 
			<?php echo form_input('address_line1', $profile->address_line1); ?>
		</p>
		<p>
			<label for="address_line2"><?php echo lang('profile_address_line2') ?></label> 
			<?php echo form_input('address_line2', $profile->address_line2); ?>
		</p>
		<p>	
			<label for="address_line3"><?php echo lang('profile_address_line3') ?></label> 
			<?php echo form_input('address_line3', $profile->address_line3); ?>
		</p>
		<p>	
			<label for="postcode"><?php echo lang('profile_address_postcode') ?></label>
			<?php echo form_input('postcode', $profile->postcode); ?>
		<p>
		<p>
			<label for="website"><?php echo lang('profile_website'); ?></label>
			<?php echo form_input('website', $profile->website); ?>
		</p>
	</fieldset>

	<fieldset id="user_social">
		<legend><?php echo lang('profile_messenger_section') ?></legend>
		<p>
			<label for="msn_handle"><?php echo lang('profile_msn_handle') ?></label>
			<?php echo form_input('msn_handle', $profile->msn_handle); ?>
		</p>
		<p>	
			<label for="aim_handle"><?php echo lang('profile_aim_handle') ?></label>
			<?php echo form_input('aim_handle', $profile->aim_handle); ?>
		</p>
		<p>
			<label for="yim_handle"><?php echo lang('profile_yim_handle') ?></label>
			<?php echo form_input('yim_handle', $profile->yim_handle); ?>
		</p>
		<p>	
			<label for="gtalk_handle"><?php echo lang('profile_gtalk_handle') ?></label>
			<?php echo form_input('gtalk_handle', $profile->gtalk_handle); ?>
		</p>
	</fieldset>

	<fieldset><legend><?php echo lang('profile_social_section') ?></legend>
		<dl>
			<dt><label for="mobile"><?php echo lang('profile_gravatar') ?></label></dt>
			<dd><?php echo form_input('gravatar', $profile->gravatar); ?></dd>
		</dl>

		<!--
		<dl>
			<dt><label for="twitter"><?php echo lang('profile_twitter') ?></label></dt>
			<dd>
				<?php if (!$this->user->twitter_access_token)
						echo anchor('users/profile/twitter', 'Connect with Twitter');
					  else
						echo 'Twitter Connected';
				?>
			</dd>
		</dl>
		-->

	</fieldset>

	<?php echo form_submit('', lang('profile_save_btn')); ?>

	<?php echo form_close(); ?>
</div>