<?php echo form_open('users/login');?>

	<ul>
<!--		<li>
			<label>Email:</label>
			<?php echo form_input('email');?>
		</li>
		<li>
			<label>Password:</label>
			<?php echo form_password('password');?>
		</li>
-->
	<li>
		<label for="email"><?php echo lang('user_email'); ?></label>
		<input type="text" id="email" name="email" maxlength="120" />
	</li>
	<li>
		<label for="password"><?php echo lang('user_password'); ?></label>
		<input type="password" id="password" name="password" maxlength="20" />
	</li>
    </ul>

	<div class="pyro-buttons">
        <?php echo form_checkbox('remember', '1', FALSE); ?><?php echo lang('user_remember')?><br />
		<button type="submit" class="login_submit">
			<?php echo lang('user_login_btn') ?>
		</button>

		<?php echo anchor('users/reset_pass', lang('user_reset_password_link'));?> | <?php echo anchor('register', lang('user_register_btn'));?>
	</div>

<?php echo form_close();?>