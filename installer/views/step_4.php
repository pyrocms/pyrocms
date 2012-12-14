<section class="title">
	<h3>{header}</h3>
</section>

<section class="item">
	<p>{intro_text}</p>
</section>

<?php echo form_open(uri_string(), 'id="install_frm"'); ?>

	<input type="hidden" id="site_ref" name="site_ref" value="default" />
<section class="title">
	<h3>{default_user}</h3>
</section>
<section class="item">
	<div class="input">
		<label for="user_name">{user_name}</label>
		<?php echo form_input(array('id' => 'user_name', 'name' => 'user_name', 'value' => set_value('user_name'))); ?>
	</div>
	<div class="input">
		<label for="user_firstname">{first_name}</label>
		<?php echo form_input(array('id' => 'user_firstname', 'name' => 'user_firstname', 'value' => set_value('user_firstname'))); ?>
	</div>
	<div class="input">
		<label for="user_lastname">{last_name}</label>
		<?php echo form_input(array('id' => 'user_lastname', 'name' => 'user_lastname', 'value' => set_value('user_lastname'))); ?>
	</div>
	<div class="input">
		<label for="user_email">{email}</label>
		<?php echo form_input(array('id' => 'user_email', 'name' => 'user_email', 'value' => set_value('user_email'))); ?>
	</div>
	<div class="input">
		<label for="user_password">{password}</label>
		<div class="password-wrapper">
			<?php echo form_password(array('id' => 'user_password', 'name' => 'user_password', 'value' => set_value('user_password'))); ?>
			<div id="progressbar"><div id="progress"></div></div>
			<div id="status"><div><span id="complexity">0% Complex</span></div></div>
		</div>
		<br style="clear:both" />
	</div>
	<hr />
	<input class="btn orange" id="next_step" type="submit" id="submit" value="<?php echo lang('finish'); ?>" />
</section>

<?php echo form_close(); ?>