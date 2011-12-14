<h2 class="page-title" id="page_title"><?php echo sprintf(lang('profile_of_title'), $usr->first_name.' '.$usr->last_name);?></h2>
<!-- Container for the user's profile -->
<div id="user_profile_container">
	<?php echo gravatar($usr->email, 50);?>
	<!-- Details about the user, such as role and when the user was registered -->
	<div id="user_details">
		<h3><?php echo lang('profile_user_details_label');?></h3>
		<p><strong><?php echo lang('profile_role_label');?>:</strong> <?php echo $usr->group; ?></p>
		<p><strong><?php echo lang('profile_registred_on_label');?>:</strong> <?php echo format_date($usr->created_on); ?></p>
		<?php if($usr->last_login > 0): ?>
		<p><strong><?php echo lang('profile_last_login_label');?>:</strong> <?php echo format_date($usr->last_login); ?></p>
		<?php endif; ?>
	</div>
<?php if($usr): ?>
	<?php if($usr->bio): ?>
	<!-- User's biography -->
	<div id="user_bio">
		<h3><?php echo lang('profile_bio'); ?></h3>
		<p><?php echo $usr->bio ?></p>
	</div>
	<?php endif; ?>
	<?php if($usr->gender || $usr->dob): ?>
	<!-- Personal user details -->
	<div id="user_personal">
		<h3><?php echo lang('profile_personal_section') ?></h3>	
		<?php if($usr->gender): ?><p><strong><?php echo lang('profile_gender'); ?>:</strong> <?php echo $usr->gender == 'm' ? lang('profile_male_label') : lang('profile_female_label') ?></p><?php endif; ?>
		<?php if($usr->dob): ?><p><strong><?php echo lang('profile_dob'); ?>:</strong> <?php echo format_date($usr->dob) ?></p><?php endif; ?>
	</div>
	<?php endif; ?>
	<?php if($usr->msn_handle || $usr->aim_handle || $usr->yim_handle || $usr->gtalk_handle): ?>
	<!-- Social corner -->
	<div id="user_social">
		<h3><?php echo lang('profile_messenger_section') ?></h3>
		<?php if($usr->msn_handle): ?><p><strong><?php echo lang('profile_msn_handle') ?>:</strong> <?php echo $usr->msn_handle ?></p><?php endif; ?>
		<?php if($usr->aim_handle): ?><p><strong><?php echo lang('profile_aim_handle') ?>:</strong> <?php echo $usr->aim_handle ?></p><?php endif; ?>
		<?php if($usr->yim_handle): ?><p><strong><?php echo lang('profile_yim_handle') ?>:</strong> <?php echo $usr->yim_handle ?></p><?php endif; ?>
		<?php if($usr->gtalk_handle): ?><p><strong><?php echo lang('profile_gtalk_handle') ?>:</strong> <?php echo $usr->gtalk_handle ?></p><?php endif; ?>
	</div>
	<?php endif; ?>
<?php else: ?>
	<!-- The user hasn't created a profile yet... -->
	<div id="user_no_profile">
		<p><?php echo lang('profile_not_set_up');?></p>
	</div>
<?php endif; ?>
</div>