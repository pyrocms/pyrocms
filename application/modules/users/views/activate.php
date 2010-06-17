<h2 id="page_title"><?php echo lang('user_register_header') ?></h2>

<div class="workflow_steps">
	<span id="active_step"><?php echo lang('user_register_step1') ?></span> &gt;
	<span><?php echo lang('user_register_step2') ?></span>
</div>

<?php if(!empty($error_string)): ?>
<div class="error_box">
	<?php echo $error_string; ?>
</div>
<?php endif;?>

<?php echo form_open('users/activate', 'id="activate-user"'); ?>
	<p>
		<label for="email"><?php echo lang('user_email') ?></label>
		<?php echo form_input('email', isset($user->email) ? $user->email : '', 'maxlength="40"');?>
	</p>

	<p>
		<label for="activation_code"><?php echo lang('user_activation_code') ?></label>
		<?php echo form_input('activation_code', '', 'maxlength="40"');?>
	</p>

	<p class="form_buttons">
		<?php echo form_submit('btnSubmit', lang('user_activate_btn'), array('class' => 'pyro_button')) ?>
	</p>
<?php echo form_close(); ?>