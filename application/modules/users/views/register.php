<h2><?php echo lang('user_register_header') ?></h2>

<p>
	<span class="spacer-right" style="background:#FFFF99;"><?php echo lang('user_register_step1') ?></span> -&gt; 
	<?php echo lang('user_register_step2') ?>
</p>

<p><?php echo lang('user_register_reasons') ?></p>

<?php if(!empty($error_string)):?>
<div class="error-box"><?php echo $error_string;?></div>
<?php endif;?>

<?php echo form_open('register', array('id'=>'register')); ?>

<p class="float-left spacer-right">
	<label for="first_name"><?php echo lang('user_first_name') ?></label><br/>
	<input type="text"name="first_name" maxlength="40" value="<?php echo $this->validation->first_name; ?>" />
</p>

<p>
	<label for="last_name"><?php echo lang('user_last_name') ?></label><br/>
	<input type="text"name="last_name" maxlength="40" value="<?php echo $this->validation->last_name; ?>" />
</p>

<p class="float-left spacer-right">
	<label for="email"><?php echo lang('user_email') ?> - <em>used to login</em></label><br/>
	<input type="text"name="email" maxlength="100" value="<?php echo $this->validation->email; ?>" />
</p>

<p>
	<label for="confirm_email"><?php echo lang('user_confirm_email') ?></label><br/>
	<input type="text"name="confirm_email" maxlength="100" value="<?php echo $this->validation->confirm_email; ?>" />
</p>

<p class="float-left spacer-right">
	<label for="password"><?php echo lang('user_password') ?></label><br/>
	<input type="password"name="password" maxlength="100" />
</p>

<p>
	<label for="confirm_password"><?php echo lang('user_confirm_password') ?></label><br/>
	<input type="password"name="confirm_password" maxlength="100" />
</p>

<?php echo form_submit('btnSubmit', lang('user_register_btn')) ?>
<?php echo form_close(); ?>