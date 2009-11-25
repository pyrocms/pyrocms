<h2><?php echo sprintf(lang('profile_of_title'), $user->full_name);?></h2>

<fieldset>
	<legend><?php echo lang('profile_user_details_label');?></legend>
	<strong><?php echo lang('profile_role_label');?>:</strong> <?php echo $user->role; ?><br/>
	<strong><?php echo lang('profile_registred_on_label');?>:</strong> <?php echo date('M d, Y', $user->created_on); ?><br/>
	<?php if($user->last_login > 0): ?>
		<strong><?php echo lang('profile_last_login_label');?>:</strong> <?php echo date('M d, Y', $user->last_login); ?>
	<?php endif; ?>
</fieldset>

<?php if($profile): ?>
	<?php if($profile->bio): ?>
		<fieldset class="width-22 float-left">
			<legend><?php echo lang('profile_bio'); ?></legend>
		
			<?php echo $profile->bio ?>
		</fieldset>
	<?php endif; ?>
	
	<fieldset class="width-22 float-right">
		<legend><?php echo lang('profile_personal_section') ?></legend>		
		<dl>
			<?php if($profile->gender): ?>
				<dt><?php echo lang('profile_gender'); ?></dt>
				<dd><?php echo $profile->gender == 'm' ? lang('profile_male_label') : lang('profile_female_label') ?></dd>
			<?php endif; ?>
			
			<?php if($profile->dob): ?>
				<dt><?php echo lang('profile_dob'); ?></dt>
				<dd><?php echo date('M d, Y', $profile->dob) ?></dd>
			<?php endif; ?>
		</dl>
	</fieldset>
	
	<fieldset class="width-22 float-left">
		<legend><?php echo lang('profile_messenger_section') ?></legend>	
		<dl>
			<?php if($profile->msn_handle): ?>
				<dt><?php echo lang('profile_msn_handle') ?></dt>
				<dd><?php echo $profile->msn_handle ?></dd>
			<?php endif; ?>
			
			<?php if($profile->aim_handle): ?>
				<dt><?php echo lang('profile_aim_handle') ?></dt>
				<dd><?php echo $profile->aim_handle ?></dd>
			<?php endif; ?>
			
			<?php if($profile->yim_handle): ?>
				<dt><?php echo lang('profile_yim_handle') ?></dt>
				<dd><?php echo $profile->yim_handle ?></dd>
			<?php endif; ?>
			
			<?php if($profile->gtalk_handle): ?>
				<dt><?php echo lang('profile_gtalk_handle') ?></dt>
				<dd><?php echo $profile->gtalk_handle ?></dd>
			<?php endif; ?>
		</dl>		
	</fieldset>
<?php else: ?>
	<p><?php echo lang('profile_not_set_up');?></p>
<?php endif; ?>