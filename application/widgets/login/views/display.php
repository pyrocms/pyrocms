<?php echo form_open('users/login');?>

	<ul>
		<li>
			<label>Email:</label>
			<?php echo form_input('login_email');?>
		</li>
		<li>
			<label>Password:</label>
			<?php echo form_password('login_password');?>
		</li>
	</ul>

	<div class="pyro-buttons">
		<button type="submit" class="login_submit">
			Login
		</button>

		<a href="<?php echo site_url('users/reset_pass'); ?>" class="reset_pass">
			Forgot password?
		</a>
	</div>

<?php echo form_close();?>