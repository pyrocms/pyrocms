<h2><?=sprintf(lang('profile_of_title'), $user->full_name);?></h2>

<fieldset>
	<legend><?=lang('profile_user_details_label');?></legend>
	<strong><?=lang('profile_role_label');?>:</strong> <?=$user->role; ?><br/>
	<strong><?=lang('profile_registred_on_label');?>:</strong> <?=date('M d, Y', $user->created_on); ?><br/>
	<? if($user->last_login > 0): ?>
		<strong><?=lang('profile_last_login_label');?>:</strong> <?=date('M d, Y', $user->last_login); ?>
	<? endif; ?>
</fieldset>

<? if($profile): ?>
	<? if($profile->bio): ?>
		<fieldset class="width-22 float-left">
			<legend><?=lang('profile_bio'); ?></legend>
		
			<?=$profile->bio ?>
		</fieldset>
	<? endif; ?>
	
	<fieldset class="width-22 float-right">
		<legend><?=lang('profile_personal_section') ?></legend>		
		<dl>
			<? if($profile->gender): ?>
				<dt><?=lang('profile_gender'); ?></dt>
				<dd><?=$profile->gender == 'm' ? lang('profile_male_label') : lang('profile_female_label') ?></dd>
			<? endif; ?>
			
			<? if($profile->dob): ?>
				<dt><?=lang('profile_dob'); ?></dt>
				<dd><?=date('M d, Y', $profile->dob) ?></dd>
			<? endif; ?>
		</dl>
	</fieldset>
	
	<fieldset class="width-22 float-left">
		<legend><?=lang('profile_messenger_section') ?></legend>	
		<dl>
			<? if($profile->msn_handle): ?>
				<dt><?=lang('profile_msn_handle') ?></dt>
				<dd><?=$profile->msn_handle ?></dd>
			<? endif; ?>
			
			<? if($profile->aim_handle): ?>
				<dt><?=lang('profile_aim_handle') ?></dt>
				<dd><?=$profile->aim_handle ?></dd>
			<? endif; ?>
			
			<? if($profile->yim_handle): ?>
				<dt><?=lang('profile_yim_handle') ?></dt>
				<dd><?=$profile->yim_handle ?></dd>
			<? endif; ?>
			
			<? if($profile->gtalk_handle): ?>
				<dt><?=lang('profile_gtalk_handle') ?></dt>
				<dd><?=$profile->gtalk_handle ?></dd>
			<? endif; ?>
		</dl>		
	</fieldset>
<? else: ?>
	<p><?=lang('profile_not_set_up');?></p>
<? endif; ?>