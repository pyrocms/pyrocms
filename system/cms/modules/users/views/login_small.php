<?php echo form_open('users/login', array('id'=>'login-small')); ?>
<?php if (isset($redirect_hash) && $redirect_hash): ?>
<?php echo form_hidden('redirect_hash', $redirect_hash); ?>
<?php endif; ?>
<ul>
	<li class="email">
		<label for="email"><?php echo lang('user_email'); ?></label>
		<input type="text" id="email" name="email" maxlength="120" />
	</li>
	<li class="pword">
		<label for="password"><?php echo lang('user_password'); ?></label>
		<input type="password" id="password" name="password" maxlength="20" />
	</li>
	<li class="form-buttons">
		<input type="submit" value="<?php echo lang('user_login_btn') ?>" name="btnLogin" /> | <?php echo anchor('register', lang('user_register_btn'));?>
	</li>
	<li class="remember-me">
		<?php echo form_checkbox('remember', '1', FALSE); ?><span><?php echo lang('user_remember')?></span>
	</li>	
</ul>
<?php echo form_close(); ?>