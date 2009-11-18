<h2><?=lang('user_login_header') ?></h2>

<?=form_open('users/login', array('id'=>'login')); ?>
	
<? if (!empty($this->validation->error_string)): ?>
	<div class="error-box"><?=$this->validation->error_string;?></div>
<? endif; ?>

<p>
	<label for="email"><?=lang('user_email')?></label>
	<input type="text" name="email" maxlength="120" value="<?= $this->validation->email; ?>" />
</p>

<p>
	<label for="password"><?=lang('user_password')?></label>
	<input type="password" name="password" maxlength="20" value="<?= $this->validation->password; ?>" />
</p>

<input type="image" src="<?=image_path('admin/fcc/btn-login.jpg');?>" value="<?=lang('user_login_btn') ?>" name="btnLogin" />
	
<?=form_close(); ?>

<p><?=anchor('users/reset_pass', lang('user_reset_password_link'));?> | <?=anchor('register', lang('user_register_btn'));?></p>