<!-- Container for the user's profile -->
<div id="user_profile_container">
	<?php echo gravatar($user->email, 50);?>
	<h2 id="page_title"><?php echo sprintf(lang('profile_of_title'), $user->first_name . ' ' . $user->last_name);?></h2>
	
	<!-- Details about the user, such as role and when the user was registered -->
	<fieldset id="user_details">
		<legend><?php echo lang('profile_user_details_label');?></legend>
		<p><strong><?php echo lang('profile_role_label');?>:</strong> <?php echo $user->group; ?></p>
		<p><strong><?php echo lang('profile_registred_on_label');?>:</strong> <?php echo date('M d, Y \a\\t g:i a', $user->created_on); ?></p>
	<?php if($user->last_login > 0): ?>
		<p><strong><?php echo lang('profile_last_login_label');?>:</strong> <?php echo date('M d, Y \a\\t g:i a', $user->last_login); ?></p>
	<?php endif; ?>
	</fieldset>

<?php if($profile): ?>
	<?php if($profile->bio): ?>
	<!-- User's biography -->
	<fieldset id="user_bio">
		<legend><?php echo lang('profile_bio'); ?></legend>
		<p><?php echo $profile->bio ?></p>
	</fieldset>
	<?php endif; ?>
	
	<!-- Personal user details -->
	<fieldset id="user_personal">
		<legend><?php echo lang('profile_personal_section') ?></legend>	
		<?php if($profile->gender): ?>
		<p><strong><?php echo lang('profile_gender'); ?>:</strong> <?php echo $profile->gender == 'm' ? lang('profile_male_label') : lang('profile_female_label') ?></p>
		<?php endif; ?>
		
		<?php if($profile->dob): ?>
			<p><strong><?php echo lang('profile_dob'); ?>:</strong> <?php echo date('M d, Y', $profile->dob) ?></p>
		<?php endif; ?>
	</fieldset>
	
	<!-- Social corner -->
	<fieldset id="user_social">
		<legend><?php echo lang('profile_messenger_section') ?></legend>
		
		<?php if($profile->msn_handle): ?>
		<p><strong><?php echo lang('profile_msn_handle') ?>:</strong> <?php echo $profile->msn_handle ?></p>
		<?php endif; ?>
		
		<?php if($profile->aim_handle): ?>
		<p><strong><?php echo lang('profile_aim_handle') ?>:</strong> <?php echo $profile->aim_handle ?></p>
		<?php endif; ?>
		
		<?php if($profile->yim_handle): ?>
		<p><strong><?php echo lang('profile_yim_handle') ?>:</strong> <?php echo $profile->yim_handle ?></p>
		<?php endif; ?>
		
		<?php if($profile->gtalk_handle): ?>
		<p><strong><?php echo lang('profile_gtalk_handle') ?>:</strong> <?php echo $profile->gtalk_handle ?></p>
		<?php endif; ?>			
	</fieldset>
<?php else: ?>
	<!-- The user hasn't created a profile yet... -->
	<div id="user_no_profile">
		<p><?php echo lang('profile_not_set_up');?></p>
	</div>
<?php endif; ?>
</div>