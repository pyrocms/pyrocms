<h2 class="page-title" id="page_title"><?php echo lang('user_register_header') ?></h2>

<p>
	<span id="active_step"><?php echo lang('user_register_step1') ?></span> -&gt; 
	<span><?php echo lang('user_register_step2') ?></span>
</p>

<p><?php echo lang('user_register_reasons') ?></p>

<?php if(!empty($error_string)):?>
<!-- Woops... -->
<div class="error-box">
	<?php echo $error_string;?>
</div>
<?php endif;?>  

<?php echo form_open('register', array('id'=>'register')); ?>
<ul>
	<li>
		<label for="first_name"><?php echo lang('user_first_name') ?></label>
		<input type="text" name="first_name" maxlength="40" value="<?php echo $user_data->first_name; ?>" />
	</li>
	
	<li>
		<label for="last_name"><?php echo lang('user_last_name') ?></label>
		<input type="text" name="last_name" maxlength="40" value="<?php echo $user_data->last_name; ?>" />
	</li>
	
	<li>
		<label for="username"><?php echo lang('user_username') ?></label>
		<input type="text" name="username" maxlength="100" value="<?php echo $user_data->username; ?>" />
	</li>
	
	<li>
		<label for="display_name"><?php echo lang('user_display_name') ?></label>
		<input type="text"name="display_name" maxlength="100" value="<?php echo $user_data->display_name; ?>" />
	</li>
	
	<li>
		<label for="email"><?php echo lang('user_email') ?> - <em><?php echo lang('user_email_use') ?></em></label>
		<input type="text" name="email" maxlength="100" value="<?php echo $user_data->email; ?>" />
	</li>
	
	<li>
		<label for="confirm_email"><?php echo lang('user_confirm_email') ?></label>
		<input type="text" name="confirm_email" maxlength="100" value="<?php echo $user_data->confirm_email; ?>" />
	</li>
	
	<li>
		<label for="password"><?php echo lang('user_password') ?></label>
		<input type="password" name="password" maxlength="100" />
	</li>
	
	<li>
		<label for="confirm_password"><?php echo lang('user_confirm_password') ?></label>
		<input type="password" name="confirm_password" maxlength="100" />
	</li>
	
	<li>
		<?php echo form_submit('btnSubmit', lang('user_register_btn')) ?>
	</li>
</ul>
<?php echo form_close(); ?>