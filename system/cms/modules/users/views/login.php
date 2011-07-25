<h2 class="page-title" id="page_title"><?php echo lang('user_login_header') ?></h2>

<?php if (validation_errors()): ?>
<div class="error-box">
	<?php echo validation_errors();?>
</div>
<?php endif; ?>

<?php echo form_open('users/login', array('id'=>'login'), array('redirect_to' => $redirect_to)); ?>
<ul>
	<li>
		<label for="email"><?php echo lang('user_email'); ?></label>
		<input type="text" id="email" name="email" maxlength="120" />
	</li>
	<li>
		<label for="password"><?php echo lang('user_password'); ?></label>
		<input type="password" id="password" name="password" maxlength="20" />
	</li>
	<li id="remember_me">
		<?php echo form_checkbox('remember', '1', FALSE); ?><?php echo lang('user_remember')?>
	</li>
	<li class="form_buttons">
		<input type="submit" value="<?php echo lang('user_login_btn') ?>" name="btnLogin" /> | <?php echo anchor('register', lang('user_register_btn'));?>
	</li>
	<li>
		<?php echo anchor('users/reset_pass', lang('user_reset_password_link'));?>
	</li>
</ul>
<?php echo form_close(); ?>