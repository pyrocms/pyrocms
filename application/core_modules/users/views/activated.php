<h2><?php echo lang('user_register_header') ?></h2>

<p>
	<?php echo lang('user_register_step1') ?> -&gt; 
	<span class="spacer-right" style="background:#FFFF99;"><?php echo lang('user_register_step2') ?></span>
</p>

<p><?php echo $this->lang->line('user_activated_message'); ?></p>

<?php echo form_open('users/login', array('id'=>'login')); ?>

	<p>
		<label for="email"><?php echo lang('user_email'); ?></label>
		<?php echo form_input('email', $activated_email) ?>
	</p>
	
	<p>	
		<label for="password"><?php echo lang('user_password'); ?></label>
		<?php echo form_password('password') ?>
	</p>
	
	<p><input type="image" src="<?php echo image_path('admin/fcc/btn-login.jpg');?>" value="<?php echo lang('user_login_btn') ?>" name="btnLogin" /></p>
	
<?php echo form_close(); ?>