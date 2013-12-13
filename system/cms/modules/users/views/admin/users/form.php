<div class="form-group">
<div class="row">
	
	<label class="col-lg-2" for="email"><?php echo lang('global:email') ?> <span>*</span></label>

	<div  class="col-lg-10">
		<?php echo form_input('email', $member->email, 'id="email" class="form-control"') ?>
	</div>

</div>
</div>


<div class="form-group">
<div class="row">
	
	<label class="col-lg-2" for="username"><?php echo lang('user:username') ?> <span>*</span></label>
	
	<div  class="col-lg-10">
		<?php echo form_input('username', $member->username, 'id="username" class="form-control"') ?>
	</div>

</div>
</div>



<?php if ( ! $member->isSuperUser() or ($member->isSuperUser() and $current_user->id != $member->id)): ?>
	
	<?php if ( ! empty($group_options)): ?>

		<div class="form-group">
		<div class="row">
			
			<label class="col-lg-2" for="group_id"><?php echo lang('user:group_label') ?></label>
			
			<div  class="col-lg-10">
				<?php echo form_multiselect('groups[]', $group_options, $member->getCurrentGroupIds()); ?>
			</div>

		</div>
		</div>

	<?php endif; ?>

	<div class="form-group">
	<div class="row">
		
		<label class="col-lg-2" for="active"><?php echo lang('user:activate_label') ?></label>
	
		<div  class="col-lg-10">
			<?php $options = array(0 => lang('user:do_not_activate'), 1 => lang('user:active'), 2 => lang('user:send_activation_email')) ?>
			<?php echo form_dropdown('active', $options, $member->is_activated, 'id="active"') ?>
		</div>

	</div>
	</div>
	
<?php endif; ?>

<div class="form-group">
	<div class="row">
		
	<label class="col-lg-2" for="password">
		<?php echo lang('global:password') ?>
		<?php if ( ! $member->getKey()): ?> <span>*</span><?php endif ?>
	</label>

	<div  class="col-lg-10">
		<?php echo form_password('password', '', 'id="password" autocomplete="off" class="form-control"'); ?>
	</div>

</div>
</div>