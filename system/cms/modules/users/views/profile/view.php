<h2 class="page-title"><?php echo sprintf(lang('profile_of_title'), $_user->display_name);?></h2>

<!-- Container for the user's profile -->
<div id="user_profile_container">
	<?php echo gravatar($_user->email, 50);?>
	<!-- Details about the user, such as role and when the user was registered -->
	<div id="user_details">
		<h3><?php echo lang('profile_user_details_label');?></h3>
		<p><strong><?php echo lang('profile_role_label');?>:</strong> <?php echo $_user->group; ?></p>
		<p><strong><?php echo lang('profile_registred_on_label');?>:</strong> <?php echo format_date($_user->created_on); ?></p>
		<?php if($_user->last_login > 0): ?>
		<p><strong><?php echo lang('profile_last_login_label');?>:</strong> <?php echo format_date($_user->last_login); ?></p>
		<?php endif; ?>
	</div>
	
<?php if ($_user): ?>
	
	<?php if ($_user->bio): ?>
	<!-- User's biography -->
	<div id="user_bio">
		<h3><?php echo lang('profile_bio'); ?></h3>
		<p><?php echo $_user->bio ?></p>
	</div>
	<?php endif; ?>
	
	<?php if($_user->gender or $_user->dob): ?>
	<!-- Personal user details -->
	<div id="user_personal">
		<h3><?php echo lang('profile_personal_section') ?></h3>	
		<?php if($_user->gender): ?><p><strong><?php echo lang('profile_gender'); ?>:</strong> <?php echo $_user->gender == 'm' ? lang('profile_male_label') : lang('profile_female_label') ?></p><?php endif; ?>
		<?php if($_user->dob): ?><p><strong><?php echo lang('profile_dob'); ?>:</strong> <?php echo format_date($_user->dob) ?></p><?php endif; ?>
	</div>
	
	<?php endif; ?>

<?php else: ?>
	<!-- The user hasn't created a profile yet... -->
	<div id="user_no_profile">
		<p><?php echo lang('profile_not_set_up');?></p>
	</div>
<?php endif; ?>
</div>