<!-- Intro page -->
<section class="title">
	<h3>{header}</h3>
</section>
<section class="item">
	<p>{intro_text}</p>
</section>

<?php echo form_open(uri_string(), 'id="install_frm"'); ?>

<section class="title">
	<h3>{db_settings}</h3>
</section>
<section class="item">
	<p>{db_text}</p>
	<?php if (!$this->installer_lib->mysql_available()): ?>
	<p class="result fail">{db_missing}</p>
	<?php endif; ?>

		<div class="input">
			<label for="database">{database}</label>
			<input type="text" id="database" class="input_text" name="database" value="<?php echo set_value('database'); ?>" />
		</div>

		<div class="input">
			<label for="create_db">{db_create}</label><br>
			<input type="checkbox" name="create_db" value="true" id="create_db" <?php if($this->input->post('create_db') == 'true') { echo ' checked="checked"'; } ?> />
			<small>({db_notice})</small>
		</div>
		
	<div class="input">
		<label for="hostname">{server}</label>
		<?php echo form_input(array('id' => 'hostname', 'name' => 'hostname'), set_value('hostname', 'localhost')); ?>
	</div>

		<div class="input">
			<label for="port">{portnr}</label>
			<?php echo form_input(array('id' => 'port', 'name' => 'port'), set_value('port', $port)); ?>
		</div>

	<div class="input">
		<label for="username">{username}</label>
		<?php echo form_input(array('id' => 'username', 'name' => 'username'), set_value('username')); ?>
	</div>

	<div class="input">
		<label for="password">{password}</label>
		<?php echo form_password(array('id' => 'password', 'name' => 'password'), set_value('password')); ?>
	</div>

	<div id="confirm_db"></div>
</section>

<section class="title">
	<h3>{server_settings}</h3>
</section>
<section class="item">
	<p>{httpserver_text}</p>

	<div class="input">
		<label for="http_server">{httpserver}</label>
		<?php echo form_dropdown('http_server', $server_options, set_value('http_server'), 'id="http_server"'); ?>
	</div>

	<input type="hidden" name="installation_step" value="step_1"/>
	<input type="submit" id="next_step" value="{step2}" class="btn orange"/>
</section>

<?php echo form_close(); ?>
