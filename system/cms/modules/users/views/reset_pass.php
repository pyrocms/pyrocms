<h2 class="page-title"><?php echo lang('user:reset_password_title');?></h2>

<?php if(!empty($error_string)):?>
	<div class="error-box">
		<?php echo $error_string;?>
	</div>
<?php endif;?>

<?php if(!empty($success_string)): ?>
	<div class="success-box">
		<?php echo $success_string ?>
	</div>
<?php else: ?>
	
	<?php echo form_open('users/reset_pass', array('id'=>'reset-pass')) ?>

	<label for="email"><?php echo lang('user:reset_instructions') ?></label>
	<input type="text" name="email" maxlength="100" value="<?php echo set_value('email') ?>" />

	<?php echo form_submit('', lang('user:reset_pass_btn')) ?>

	<?php echo form_close() ?>
	
<?php endif ?>