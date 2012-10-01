<?php echo form_open('users/login');?>
<?php if (isset($redirect_hash) && $redirect_hash): ?>
<?php echo form_hidden('redirect_hash', $redirect_hash); ?>
<?php endif; ?>
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
        <?php echo form_checkbox('remember', '1', false); ?><?php echo lang('user_remember')?><br />
		<button type="submit" class="login_submit">
			<?php echo lang('user_login_btn') ?>
		</button>

		<?php echo anchor('users/reset_pass', lang('user_reset_password_link'));?>
		<?php if (Settings::get('enable_registration')) echo ' | '.anchor('register', lang('user_register_btn')); ?>
	</div>

<?php echo form_close();?>