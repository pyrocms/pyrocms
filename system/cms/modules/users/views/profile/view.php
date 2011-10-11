<h2 class="page-title" id="page_title"><?php echo sprintf(lang('profile_of_title'), $user->first_name.' '.$user->last_name);?></h2>
<!-- Container for the user's profile -->
<div id="user_profile_container">
	<?php echo gravatar($user->email, 50);?>
	<!-- Details about the user, such as role and when the user was registered -->
	<div id="user_details">
		<h3><?php echo lang('profile_user_details_label');?></h3>
		<p><strong><?php echo lang('profile_role_label');?>:</strong> <?php echo $user->group; ?></p>
		<p><strong><?php echo lang('profile_registred_on_label');?>:</strong> <?php echo format_date($user->created_on); ?></p>
		<?php if($user->last_login > 0): ?>
		<p><strong><?php echo lang('profile_last_login_label');?>:</strong> <?php echo format_date($user->last_login); ?></p>
		<?php endif; ?>
	</div>
<?php if($user): ?>
	<?php if($user->bio): ?>
	<!-- User's biography -->
	<div id="user_bio">
		<h3><?php echo lang('profile_bio'); ?></h3>
		<p><?php echo $user->bio ?></p>
	</div>
	<?php endif; ?>
	<?php if($user->gender || $user->dob): ?>
	<!-- Personal user details -->
	<div id="user_personal">
		<h3><?php echo lang('profile_personal_section') ?></h3>	
		<?php if($user->gender): ?><p><strong><?php echo lang('profile_gender'); ?>:</strong> <?php echo $user->gender == 'm' ? lang('profile_male_label') : lang('profile_female_label') ?></p><?php endif; ?>
		<?php if($user->dob): ?><p><strong><?php echo lang('profile_dob'); ?>:</strong> <?php echo format_date($user->dob) ?></p><?php endif; ?>
	</div>
	<?php endif; ?>
	<?php if($user->msn_handle || $user->aim_handle || $user->yim_handle || $user->gtalk_handle): ?>
	<!-- Social corner -->
	<div id="user_social">
		<h3><?php echo lang('profile_messenger_section') ?></h3>
		<?php if($user->msn_handle): ?><p><strong><?php echo lang('profile_msn_handle') ?>:</strong> <?php echo $user->msn_handle ?></p><?php endif; ?>
		<?php if($user->aim_handle): ?><p><strong><?php echo lang('profile_aim_handle') ?>:</strong> <?php echo $user->aim_handle ?></p><?php endif; ?>
		<?php if($user->yim_handle): ?><p><strong><?php echo lang('profile_yim_handle') ?>:</strong> <?php echo $user->yim_handle ?></p><?php endif; ?>
		<?php if($user->gtalk_handle): ?><p><strong><?php echo lang('profile_gtalk_handle') ?>:</strong> <?php echo $user->gtalk_handle ?></p><?php endif; ?>
	</div>
	<?php endif; ?>
<?php else: ?>
	<!-- The user hasn't created a profile yet... -->
	<div id="user_no_profile">
		<p><?php echo lang('profile_not_set_up');?></p>
	</div>
<?php endif; ?>
</div>