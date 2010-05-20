<h2><?php echo lang('user_register_header') ?></h2>

<div class="workflow-steps">
	<span class="active-step"><?php echo lang('user_register_step1') ?></span> &gt;
	<span class="step"><?php echo lang('user_register_step2') ?></span>
</div>

<?php if(!empty($error_string)): ?>
<div class="error-box"><?php echo $error_string; ?></div>
<?php endif;?>

<?php echo form_open('users/activate', 'id="activate-user"'); ?>
<ul id="users-activate">
	<li>
		<label for="email"><?php echo lang('user_email') ?></label>
		<?php echo form_input('email', isset($user->email) ? $user->email : '', 'maxlength="40"');?>
	</li>

	<li>
		<label for="activation_code"><?php echo lang('user_activation_code') ?></label>
		<?php echo form_input('activation_code', '', 'maxlength="40"');?>
	</li>

	<li class="form-buttons">
		<?php echo form_submit('btnSubmit', lang('user_activate_btn'), array('class' => 'pyro-button')) ?>
	</li>
</ul>
<?php echo form_close(); ?>