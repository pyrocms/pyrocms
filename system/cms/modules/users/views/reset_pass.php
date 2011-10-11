<h2 class="page-title"><?php echo lang('user_reset_password_title');?></h2>

<?php if(!empty($error_string)):?>
	<div class="error-box">
		<?php echo $error_string;?>
	</div>
<?php endif;?>

<?php if(!empty($success_string)): ?>
	<div class="success-box">
		<?php echo $success_string; ?>
	</div>
<?php else: ?>

	<?php echo form_open('users/reset_pass', array('id'=>'reset-pass')); ?>
	<ul>
		<li>
			<label for="user_name"><?php echo lang('user_username') ?></label>
			<input type="text" name="user_name" maxlength="40" value="<?php echo set_value('user_name'); ?>" />
		</li>
		<li>
			<label for="email"><?php echo lang('user_email') ?></label>
			<input type="text" name="email" maxlength="100" value="<?php echo set_value('email'); ?>" />
		</li>
		<li>
			<?php echo form_submit('btnSubmit', lang('user_reset_pass_btn')) ?>
		</li>
	</ul>
	<?php echo form_close(); ?>
	
<?php endif; ?>