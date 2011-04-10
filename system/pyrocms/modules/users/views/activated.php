<h2 class="page-title" id="page_title"><?php echo lang('user_login_header') ?></h2>

<div class="success-box">
	<?php echo $this->lang->line('user_activated_message'); ?>
</div>

<?php echo form_open('users/login', array('id'=>'login')); ?>
<ul>
	<li>
		<label for="email"><?php echo lang('user_email'); ?></label>
		<?php echo form_input('email') ?>
	</li>
	
	<li>
		<label for="password"><?php echo lang('user_password'); ?></label>
		<?php echo form_password('password') ?>
	</li>
	
	<li class="form_buttons">
		<input type="submit" value="<?php echo lang('user_login_btn') ?>" name="btnLogin" />
	</li>
</ul>
<?php echo form_close(); ?>