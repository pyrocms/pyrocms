<h2 id="page_title" class="page-title">
	<?php echo ($this->current_user->id !== $usr->id) ?
					sprintf(lang('user_edit_title'), $usr->first_name.' '.$usr->last_name) :
					lang('profile_edit') ?>
</h2>
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
				<?php echo form_input('first_name', $usr->first_name); ?>
			</li>

			<li>
				<label for="last_name"><?php echo lang('user_last_name') ?></label><br/>
				<?php echo form_input('last_name', $usr->last_name); ?>
			</li>
			<li>
				<label for="display_name"><?php echo lang('profile_display_name') ?></label>
				<?php echo form_input('display_name', set_value('display_name', $usr->display_name)); ?>
			</li>
			</ul>
	</fieldset>

	<fieldset id="user_password">
		<legend><?php echo lang('user_password_section') ?></legend>
		<ul>
			<li class="float-left spacer-right">
				<label for="password"><?php echo lang('user_password') ?></label><br/>
				<?php echo form_password('password', '', 'autocomplete="off"'); ?>
			</li>
		</ul>
	</fieldset>

	<fieldset>
		<legend><?php echo lang('user_other_settings_section') ?></legend>
		<ul>
			<li>
				<label for="lang"><?php echo lang('user_lang') ?></label><br/>
				<?php echo form_dropdown('lang', $languages, $usr->lang); ?>
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
						<?php echo form_dropdown('dob_day', $days, isset($usr->dob_day) ? $usr->dob_day : 1) ?>
					</div>
					<div>
						<label for="dob_month"><?php echo lang('profile_dob_month') ?>:</label>
						<?php echo form_dropdown('dob_month', $months, isset($usr->dob_month) ? $usr->dob_month : 1) ?>
					</div>
					<div>
						<label for="dob_year"><?php echo lang('profile_dob_year') ?>:</label>
						<?php echo form_dropdown('dob_year', $years, isset($usr->dob_year) ? $usr->dob_year : null) ?>
					</div>
				</div>
			</li>
	
			<li>
				<label for="gender"><?php echo lang('profile_gender') ?></label>
				<?php echo form_dropdown('gender', array(''=> lang('profile_gender_nt'), 'm'=>lang('profile_gender_male'), 'f'=>lang('profile_gender_female')), $usr->gender); ?>
			</li>
		
			<li>
				<label for="bio"><?php echo lang('profile_bio') ?></label>
				<?php echo form_textarea(array('name'=>'bio', 'value'=>$usr->bio, 'cols'=>60, 'rows'=>8)); ?>
			</li>
		</ul>
	</fieldset>

	<fieldset id="user_contact">
		<legend><?php echo lang('profile_contact_section') ?></legend>
		<ul>
			<li>
				<label for="phone"><?php echo lang('profile_phone') ?></label>
				<?php echo form_input('phone', $usr->phone); ?>
			</li>	
			<li>
				<label for="mobile"><?php echo lang('profile_mobile') ?></label>
				<?php echo form_input('mobile', $usr->mobile); ?>
			</li>
			<li>
				<label for="address_line1"><?php echo lang('profile_address_line1') ?></label>
				<?php echo form_input('address_line1', $usr->address_line1); ?>
			</li>
			<li>
				<label for="address_line2"><?php echo lang('profile_address_line2') ?></label>
				<?php echo form_input('address_line2', $usr->address_line2); ?>
			</li>
			<li>	
				<label for="address_line3"><?php echo lang('profile_address_line3') ?></label>
				<?php echo form_input('address_line3', $usr->address_line3); ?>
			</li>
			<li>	
				<label for="postcode"><?php echo lang('profile_address_postcode') ?></label>
				<?php echo form_input('postcode', $usr->postcode); ?>
			</li>
			<li>
				<label for="website"><?php echo lang('profile_website'); ?></label>
				<?php echo form_input('website', $usr->website); ?>
			</li>
		</ul>
	</fieldset>

	<?php echo form_submit('', lang('profile_save_btn')); ?>
	<?php echo form_close(); ?>
</div>