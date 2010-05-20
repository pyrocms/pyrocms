<h2><?php echo lang('user_register_header') ?></h2>

<div class="workflow-steps">
	<span class="step"><?php echo lang('user_register_step1') ?></span> &gt;
	<span class="active-step"><?php echo lang('user_register_step2') ?></span>
</div>

<div class="success-box">
	<?php echo $this->lang->line('user_activated_message'); ?>
</div>

<?php echo form_open('users/login', array('id'=>'login')); ?>
<ul id="users-activated">
	<li>
		<label for="email"><?php echo lang('user_email'); ?></label>
		<?php echo form_input('email') ?>
	</li>
	
	<li>
		<label for="password"><?php echo lang('user_password'); ?></label>
		<?php echo form_password('password') ?>
	</li>
	
	<li class="form-buttons">
		<input type="submit" value="<?php echo lang('user_login_btn') ?>" name="btnLogin" />
	</li>
</ul>
<?php echo form_close(); ?>