<h2><?php echo lang('user_login_header') ?></h2>
<?php echo form_open('users/login', array('id'=>'login_small')); ?>
<ul id="small-login">
	<li>
		<label for="email"><?php echo lang('user_email'); ?></label>
		<input type="text" id="email" name="email" maxlength="120" />
	</li>
	<li>
		<label for="password"><?php echo lang('user_password'); ?></label>
		<input type="password" id="password" name="password" maxlength="20" />
	</li>
	<li id="remember-me">
		<?php echo form_checkbox('remember', '1', FALSE); ?>
		<label for="remember"><?php echo lang('user_remember')?></label>
	</li>
	<li class="form-buttons">
		<label for="nothing">&nbsp;</label>
		<input type="submit" value="<?php echo lang('user_login_btn') ?>" name="btnLogin" /> or <?php echo anchor('register', lang('user_register_btn'));?>
	</li>
</ul>
<?php echo form_close(); ?>