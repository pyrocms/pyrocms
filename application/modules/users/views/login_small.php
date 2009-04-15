<?=form_open('users/login', array('id'=>'login_small')); ?>

<div class="float-left" style="width:20em">
	<label for="email"><?= lang('user_email'); ?></label>
	<input type="text" id="email" name="email" maxlength="120" />
	
	<div class="spacer-bottom"></div>
	
	<label for="password"><?= lang('user_password'); ?></label>
	<input type="password" id="password" name="password" maxlength="20" />
</div>

<div class="float-right align-center spacer-left">
	<input type="image" src="<?=image_path('admin/fcc/btn-login.jpg');?>" value="<?=lang('user_login_btn') ?>" name="btnLogin" /><br />
	or <?=anchor('register', lang('user_register_btn'));?>
</div>

<?=form_close(); ?>