<?php echo form_open('users/login', '', array('redirect_to' => current_url())); ?>

<ul>
    <li>
        <label for="email"><?php echo lang('global:email'); ?></label>
		<?php echo form_input('email', '', 'id="email" maxlength="120"'); ?>
    </li>
    <li>
        <label for="password"><?php echo lang('global:password'); ?></label>
		<?php echo form_password('password', '', 'id="password" maxlength="20"'); ?>
    </li>
</ul>

<div class="pyro-buttons">
	<?php echo form_checkbox('remember', '1', false); ?><?php echo lang('user:remember')?><br/>

	<button type="submit" class="login_submit"><?php echo lang('user:login_btn') ?></button>
	<?php echo anchor('users/reset_pass', lang('user:reset_password_link'));?>
	<?php if (Settings::get('enable_registration')): ?>
	<?php echo ' | '.anchor('register', lang('user:register_btn')); ?>
	<?php endif; ?>
</div>

<?php echo form_close(); ?>