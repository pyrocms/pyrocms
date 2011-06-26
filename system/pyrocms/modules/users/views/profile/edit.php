<h2 id="page_title" class="page-title"><?php echo lang('profile_edit') ?></h2>
<div>
	<?php if(validation_errors()):?>
	<div class="error-box">
		<?php echo validation_errors();?>
	</div>
	<?php endif;?>
   
	<?php echo form_open('edit-profile', array('id'=>'user_edit'));?>

	<fieldset id="user_personal">
		<legend><?php echo lang('profile_personal_section') ?></legend>
		<ul>
			<li>
			<label for="display_name"><?php echo lang('profile_display_name') ?></label>
			<?php echo form_input('display_name', set_value('display_name', $profile->display_name)); ?>
			</li>
			
			<li class="multiple_fields">
				<label><?php echo lang('profile_dob') ?></label>
				<div class="fields">
					<div>
						<label for="dob_day"><?php echo lang('profile_dob_day') ?>:</label>
						<?php echo form_input('dob_day', $profile->dob_day) ?>
					</div>
					<div>
						<label for="dob_month"><?php echo lang('profile_dob_month') ?>:</label>
						<?php echo form_dropdown('dob_month', $months, $profile->dob_month) ?>
					</div>
					<div>
						<label for="dob_year"><?php echo lang('profile_dob_year') ?>:</label>
						<?php echo form_input('dob_year', $profile->dob_year) ?>
					</div>
				</div>
			</li>
	
			<li>
				<label for="gender"><?php echo lang('profile_gender') ?></label>
				<?php echo form_dropdown('gender', array(''=> lang('profile_gender_nt'), 'm'=>lang('profile_gender_male'), 'f'=>lang('profile_gender_female')), $profile->gender); ?>
			</li>
		
			<li>
				<label for="bio"><?php echo lang('profile_bio') ?></label>
				<?php echo form_textarea(array('name'=>'bio', 'value'=>$profile->bio, 'cols'=>60, 'rows'=>8)); ?>
			</li>
		</ul>
	</fieldset>

	<fieldset id="user_contact">
		<legend><?php echo lang('profile_contact_section') ?></legend>
		<ul>
			<li>
				<label for="phone"><?php echo lang('profile_phone') ?></label>
				<?php echo form_input('phone', $profile->phone); ?>
			</li>	
			<li>
				<label for="mobile"><?php echo lang('profile_mobile') ?></label>
				<?php echo form_input('mobile', $profile->mobile); ?>
			</li>
			<li>
				<label for="address_line1"><?php echo lang('profile_address_line1') ?></label> 
				<?php echo form_input('address_line1', $profile->address_line1); ?>
			</li>
			<li>
				<label for="address_line2"><?php echo lang('profile_address_line2') ?></label> 
				<?php echo form_input('address_line2', $profile->address_line2); ?>
			</li>
			<li>	
				<label for="address_line3"><?php echo lang('profile_address_line3') ?></label> 
				<?php echo form_input('address_line3', $profile->address_line3); ?>
			</li>
			<li>	
				<label for="postcode"><?php echo lang('profile_address_postcode') ?></label>
				<?php echo form_input('postcode', $profile->postcode); ?>
			</li>
			<li>
				<label for="website"><?php echo lang('profile_website'); ?></label>
				<?php echo form_input('website', $profile->website); ?>
			</li>
		</ul>
	</fieldset>

	<fieldset id="user_social">
		<legend><?php echo lang('profile_messenger_section') ?></legend>
		<ul>
			<li>
				<label for="msn_handle"><?php echo lang('profile_msn_handle') ?></label>
				<?php echo form_input('msn_handle', $profile->msn_handle); ?>
			</li>
			<li>	
				<label for="aim_handle"><?php echo lang('profile_aim_handle') ?></label>
				<?php echo form_input('aim_handle', $profile->aim_handle); ?>
			</li>
			<li>
				<label for="yim_handle"><?php echo lang('profile_yim_handle') ?></label>
				<?php echo form_input('yim_handle', $profile->yim_handle); ?>
			</li>
			<li>	
				<label for="gtalk_handle"><?php echo lang('profile_gtalk_handle') ?></label>
				<?php echo form_input('gtalk_handle', $profile->gtalk_handle); ?>
			</li>
		</ul>
	</fieldset>

	<fieldset>
		<legend><?php echo lang('profile_social_section') ?></legend>
		<ul>
			<li>
				<label for="mobile"><?php echo lang('profile_gravatar') ?></label>
				<?php echo form_input('gravatar', $profile->gravatar); ?>
			</li>
		<!--
			<li>
				<label for="twitter"><?php echo lang('profile_twitter') ?></label></dt>
				<?php echo (!$this->user->twitter_access_token) ? anchor('users/profile/twitter', 'Connect with Twitter') : 'Twitter Connected'; ?>
			</li>
		-->
		</ul>
	</fieldset>
	<?php echo form_submit('', lang('profile_save_btn')); ?>
	<?php echo form_close(); ?>
</div>