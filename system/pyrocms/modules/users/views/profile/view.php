<h2 class="page-title" id="page_title"><?php echo sprintf(lang('profile_of_title'), $view_user->first_name.' '.$view_user->last_name);?></h2>
<!-- Container for the user's profile -->
<div id="user_profile_container">
	<?php echo gravatar($view_user->email, 50);?>
	<!-- Details about the user, such as role and when the user was registered -->
	<div id="user_details">
		<h3><?php echo lang('profile_user_details_label');?></h3>
		<p><strong><?php echo lang('profile_role_label');?>:</strong> <?php echo $view_user->group; ?></p>
		<p><strong><?php echo lang('profile_registred_on_label');?>:</strong> <?php echo format_date($view_user->created_on); ?></p>
		<?php if($view_user->last_login > 0): ?>
		<p><strong><?php echo lang('profile_last_login_label');?>:</strong> <?php echo format_date($view_user->last_login); ?></p>
		<?php endif; ?>
	</div>
<?php if($profile): ?>
	<?php if($profile->bio): ?>
	<!-- User's biography -->
	<div id="user_bio">
		<h3><?php echo lang('profile_bio'); ?></h3>
		<p><?php echo $profile->bio ?></p>
	</div>
	<?php endif; ?>
	<?php if($profile->gender || $profile->dob): ?>
	<!-- Personal user details -->
	<div id="user_personal">
		<h3><?php echo lang('profile_personal_section') ?></h3>	
		<?php if($profile->gender): ?><p><strong><?php echo lang('profile_gender'); ?>:</strong> <?php echo $profile->gender == 'm' ? lang('profile_male_label') : lang('profile_female_label') ?></p><?php endif; ?>
		<?php if($profile->dob): ?><p><strong><?php echo lang('profile_dob'); ?>:</strong> <?php echo format_date($profile->dob) ?></p><?php endif; ?>
	</div>
	<?php endif; ?>
	<?php if($profile->msn_handle || $profile->aim_handle || $profile->yim_handle || $profile->gtalk_handle): ?>
	<!-- Social corner -->
	<div id="user_social">
		<h3><?php echo lang('profile_messenger_section') ?></h3>
		<?php if($profile->msn_handle): ?><p><strong><?php echo lang('profile_msn_handle') ?>:</strong> <?php echo $profile->msn_handle ?></p><?php endif; ?>
		<?php if($profile->aim_handle): ?><p><strong><?php echo lang('profile_aim_handle') ?>:</strong> <?php echo $profile->aim_handle ?></p><?php endif; ?>
		<?php if($profile->yim_handle): ?><p><strong><?php echo lang('profile_yim_handle') ?>:</strong> <?php echo $profile->yim_handle ?></p><?php endif; ?>
		<?php if($profile->gtalk_handle): ?><p><strong><?php echo lang('profile_gtalk_handle') ?>:</strong> <?php echo $profile->gtalk_handle ?></p><?php endif; ?>
	</div>
	<?php endif; ?>
<?php else: ?>
	<!-- The user hasn't created a profile yet... -->
	<div id="user_no_profile">
		<p><?php echo lang('profile_not_set_up');?></p>
	</div>
<?php endif; ?>
</div>