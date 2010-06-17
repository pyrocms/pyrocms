<h2 id="page_title"><?php echo lang('user_register_header') ?></h2>

<div class="workflow_steps">
	<span><?php echo lang('user_register_step1') ?></span> &gt;
	<span id="active_step"><?php echo lang('user_register_step2') ?></span>
</div>

<div class="success_box">
	<?php echo $this->lang->line('user_activated_message'); ?>
</div>

<?php echo form_open('users/login', array('id'=>'login')); ?>
	<p>
		<label for="email"><?php echo lang('user_email'); ?></label>
		<?php echo form_input('email') ?>
	</p>
	
	<p>
		<label for="password"><?php echo lang('user_password'); ?></label>
		<?php echo form_password('password') ?>
	</p>
	
	<p class="form_buttons">
		<input type="submit" value="<?php echo lang('user_login_btn') ?>" name="btnLogin" />
	</p>
<?php echo form_close(); ?>