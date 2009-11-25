<h2><?php echo lang('user_reset_password_title');?></h2>

<?php if(!empty($error_string)):?>
<div class="error-box"><?php echo $error_string;?></div>
<?php endif;?>

<?php echo form_open('users/reset_pass', array('id'=>'reset_pass')); ?>

<p class="float-left spacer-right">
	<label for="first_name"><?php echo lang('user_first_name') ?></label><br/>
	<input type="text"name="first_name" maxlength="40" value="<?php echo isset($first_name) ? $first_name : ''; ?>" />
</p>

<p>
	<label for="last_name"><?php echo lang('user_last_name') ?></label><br/>
	<input type="text"name="last_name" maxlength="40" value="<?php echo isset($last_name) ? $last_name : ''; ?>" />
</p>

<p>
	<label for="email">E-mail</label><br/>
	<input type="text"name="email" maxlength="100" value="<?php echo isset($email) ? $email : ''; ?>" />
</p>

<?php echo form_submit('btnSubmit', lang('user_reset_pass_btn')) ?>
<?php echo form_close(); ?>