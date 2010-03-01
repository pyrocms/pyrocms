<h2><?php echo lang('user_register_header') ?></h2>

<p>
	<?php echo lang('user_register_step1') ?> -&gt; 
	<span class="spacer-right" style="background:#FFFF99;"><?php echo lang('user_register_step2') ?></span>
</p>

<?php if(!empty($error_string)):?>
<div class="error-box"><?php echo $error_string;?></div>
<?php endif;?>

<?php echo form_open('users/activate'); ?>
	
<p>
	<label for="email"><?php echo lang('user_email') ?></label><br/>
	<input type="text"name="email" maxlength="50" value="<?php echo isset($user->email) ? $user->email : '' ?>" />
</p>

<p>
	<label for="activation_code"><?php echo lang('user_activation_code') ?></label><br/>
	<input type="text"name="activation_code" maxlength="8" />
</p>

<?php echo form_submit('btnSubmit', lang('user_activate_btn')) ?>
<?php echo form_close(); ?>