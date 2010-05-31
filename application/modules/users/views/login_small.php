<h2 id="page_title"><?php echo lang('user_login_header') ?></h2>
<?php echo form_open('users/login', array('id'=>'login_small')); ?>
	<p>
		<label for="email"><?php echo lang('user_email'); ?></label>
		<input type="text" id="email" name="email" maxlength="120" />
	</p>
	<p>
		<label for="password"><?php echo lang('user_password'); ?></label>
		<input type="password" id="password" name="password" maxlength="20" />
	</p>
	<p id="remember_me">
		<?php echo form_checkbox('remember', '1', FALSE); ?><?php echo lang('user_remember')?>
	</p>
	<p class="form_buttons">
		<input type="submit" value="<?php echo lang('user_login_btn') ?>" name="btnLogin" /> or <?php echo anchor('register', lang('user_register_btn'));?>
	</p>
<?php echo form_close(); ?>