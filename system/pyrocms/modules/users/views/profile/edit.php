<h2 id="page_title" class="page-title"><?php echo lang('profile_edit') ?></h2>
<div>
	<?php if(validation_errors()):?>
	<div class="error-box">
		<?php echo validation_errors();?>
	</div>
	<?php endif;?>
   
	<?php echo form_open('edit-settings', array('id'=>'user_edit'));?>

	<fieldset id="user_names">
		<legend><?php echo lang('user_details_section') ?></legend>
		<ul>
			<li class="float-left spacer-right">
				<label for="first_name"><?php echo lang('user_first_name') ?></label><br/>
				<?php echo form_input('first_name', $user_settings->first_name); ?>
			</li>

			<li>
				<label for="last_name"><?php echo lang('user_last_name') ?></label><br/>
				<?php echo form_input('last_name', $user_settings->last_name); ?>
			</li>
			<li>
				<label for="display_name"><?php echo lang('profile_display_name') ?></label>
				<?php echo form_input('display_name', set_value('display_name', $user_settings->display_name)); ?>
			</li>
			</ul>
	</fieldset>

	<fieldset id="user_password">
		<legend><?php echo lang('user_password_section') ?></legend>
		<ul>
			<li class="float-left spacer-right">
				<label for="password"><?php echo lang('user_password') ?></label><br/>
				<?php echo form_password('password'); ?>
			</li>

			<li>
				<label for="confirm_password"><?php echo lang('user_confirm_password') ?></label><br/>
				<?php echo form_password('confirm_password'); ?>
			</li>
		</ul>
	</fieldset>

	<fieldset>
		<legend><?php echo lang('user_other_settings_section') ?></legend>
		<ul>
			<li>
				<label for="lang"><?php echo lang('user_lang') ?></label><br/>
				<?php echo form_dropdown('lang', $languages, $user_settings->lang); ?>
			</li>
		</ul>
	</fieldset>
	
	<fieldset id="user_personal">
		<legend><?php echo lang('profile_personal_section') ?></legend>
		<ul>
			<li class="multiple_fields">
				<label><?php echo lang('profile_dob') ?></label>
				<div class="fields">
					<div>
						<label for="dob_day"><?php echo lang('profile_dob_day') ?>:</label>
						<?php echo form_input('dob_day', $user_settings->dob_day) ?>
					</div>
					<div>
						<label for="dob_month"><?php echo lang('profile_dob_month') ?>:</label>
						<?php echo form_dropdown('dob_month', $months, $user_settings->dob_month) ?>
					</div>
					<div>
						<label for="dob_year"><?php echo lang('profile_dob_year') ?>:</label>
						<?php echo form_input('dob_year', $user_settings->dob_year) ?>
					</div>
				</div>
			</li>
	
			<li>
				<label for="gender"><?php echo lang('profile_gender') ?></label>
				<?php echo form_dropdown('gender', array(''=> lang('profile_gender_nt'), 'm'=>lang('profile_gender_male'), 'f'=>lang('profile_gender_female')), $user_settings->gender); ?>
			</li>
		
			<li>
				<label for="bio"><?php echo lang('profile_bio') ?></label>
				<?php echo form_textarea(array('name'=>'bio', 'value'=>$user_settings->bio, 'cols'=>60, 'rows'=>8)); ?>
			</li>
		</ul>
	</fieldset>

	<fieldset id="user_contact">
		<legend><?php echo lang('profile_contact_section') ?></legend>
		<ul>
			<li>
				<label for="phone"><?php echo lang('profile_phone') ?></label>
				<?php echo form_input('phone', $user_settings->phone); ?>
			</li>	
			<li>
				<label for="mobile"><?php echo lang('profile_mobile') ?></label>
				<?php echo form_input('mobile', $user_settings->mobile); ?>
			</li>
			<li>
				<label for="address_line1"><?php echo lang('profile_address_line1') ?></label> 
				<?php echo form_input('address_line1', $user_settings->address_line1); ?>
			</li>
			<li>
				<label for="address_line2"><?php echo lang('profile_address_line2') ?></label> 
				<?php echo form_input('address_line2', $user_settings->address_line2); ?>
			</li>
			<li>	
				<label for="address_line3"><?php echo lang('profile_address_line3') ?></label> 
				<?php echo form_input('address_line3', $user_settings->address_line3); ?>
			</li>
			<li>	
				<label for="postcode"><?php echo lang('profile_address_postcode') ?></label>
				<?php echo form_input('postcode', $user_settings->postcode); ?>
			</li>
			<li>
				<label for="website"><?php echo lang('profile_website'); ?></label>
				<?php echo form_input('website', $user_settings->website); ?>
			</li>
		</ul>
	</fieldset>

	<fieldset id="user_social">
		<legend><?php echo lang('profile_messenger_section') ?></legend>
		<ul>
			<li>
				<label for="msn_handle"><?php echo lang('profile_msn_handle') ?></label>
				<?php echo form_input('msn_handle', $user_settings->msn_handle); ?>
			</li>
			<li>	
				<label for="aim_handle"><?php echo lang('profile_aim_handle') ?></label>
				<?php echo form_input('aim_handle', $user_settings->aim_handle); ?>
			</li>
			<li>
				<label for="yim_handle"><?php echo lang('profile_yim_handle') ?></label>
				<?php echo form_input('yim_handle', $user_settings->yim_handle); ?>
			</li>
			<li>	
				<label for="gtalk_handle"><?php echo lang('profile_gtalk_handle') ?></label>
				<?php echo form_input('gtalk_handle', $user_settings->gtalk_handle); ?>
			</li>
		</ul>
	</fieldset>

	<fieldset>
		<legend><?php echo lang('profile_social_section') ?></legend>
		<ul>
			<li>
				<label for="mobile"><?php echo lang('profile_gravatar') ?></label>
				<?php echo form_input('gravatar', $user_settings->gravatar); ?>
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