<?php echo form_open('users/login', array('id'=>'login-small'), array('redirect_to' => $redirect_to)) ?>

<ul>
	<li class="email">
		<label for="email"><?php echo lang('global:email') ?></label>
		<input type="text" id="email" name="email" maxlength="120" />
	</li>
	<li class="pword">
		<label for="password"><?php echo lang('global:password') ?></label>
		<input type="password" id="password" name="password" maxlength="20" />
	</li>
	<li class="form-buttons">
		<input type="submit" value="<?php echo lang('user:login_btn') ?>" name="btnLogin" />
		<?php if (Settings::get('enable_registration')): ?>
		<?php echo ' | '.anchor('register', lang('user:register_btn')) ?>
		<?php endif ?>
	</li>
	<li class="remember-me">
		<?php echo form_checkbox('remember', '1', false) ?><span><?php echo lang('user:remember')?></span>
	</li>	
</ul>
<?php echo form_close() ?>