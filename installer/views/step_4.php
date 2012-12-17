<section class="title">
	<h3>{header}</h3>
</section>
<section class="item">
	<p>{intro_text}</p>
</section>

<?php echo form_open(uri_string(), 'id="install_frm"') ?>

<section class="title">
	<h3>{default_user}</h3>
</section>
<section class="item">
	<div class="input">
		<label for="username">{username}</label>
		<?php echo form_input(array('id' => 'username', 'name' => 'user[username]'),set_value('user[username]')) ?>
	</div>
	<div class="input">
		<label for="firstname">{firstname}</label>
		<?php echo form_input(array('id' => 'firstname', 'name' => 'user[firstname]'), set_value('user[firstname]')) ?>
	</div>
	<div class="input">
		<label for="lastname">{lastname}</label>
		<?php echo form_input(array('id' => 'lastname', 'name' => 'user[lastname]'), set_value('user[lastname]')) ?>
	</div>
	<div class="input">
		<label for="email">{email}</label>
		<?php echo form_input(array('id' => 'email', 'name' => 'user[email]'), set_value('user[email]')) ?>
	</div>
	<div class="input">
		<label for="password">{password}</label>
		<div class="password-wrapper">
			<?php echo form_password(array('id' => 'user_password', 'name' => 'user[password]', 'value' => set_value('user[password]'))) ?>
			<div id="progressbar"><div id="progress"></div></div>
			<div id="status"><div><span id="complexity">0% Complex</span></div></div>
		</div>
		<br style="clear:both" />
	</div>
	<hr />
	<input class="btn orange" id="next_step" type="submit" value="{finish}" />
</section>

<?php echo form_close() ?>
