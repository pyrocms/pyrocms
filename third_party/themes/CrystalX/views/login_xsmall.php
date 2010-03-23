<?php echo form_open('users/login', array('id'=>'login_small')); ?>

<div class="float-left" style="width:20em">
	<table>
	<tr><td>
	<label for="email"><?php echo lang('user_email'); ?></label>
	</td><td>
	<input type="text" id="email" name="email" size=13 maxlength="120" />
	</td>
	<div class="spacer-bottom"></div>
	</tr>
	<tr><td>
	<label for="password"><?php echo lang('user_password'); ?></label>
	</td><td>
	<input type="password" id="password" name="password" size=13 maxlength="20" />
	</td></tr>
	</table>
</div>

<div class="float-right align-center spacer-left">
	<input type="image" src="<?php echo image_path('admin/fcc/btn-login.jpg');?>" value="<?php echo lang('user_login_btn') ?>" name="btnLogin" />
	or <?php echo anchor('register', lang('user_register_btn'));?>
</div>

<?php echo form_close(); ?>