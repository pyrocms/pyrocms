<!-- Intro page -->
<h2>{header}</h2>

<p class="text">{intro_text}</p>

<h3>{db_settings}</h3>

<p class="text">{db_text}</p>

<?php echo form_open(uri_string(), 'id="install_frm"'); ?>
	<p>
		<label for="hostname">{server}</label>
		<?php
			echo form_input(array(
				'id' => 'hostname',
				'name' => 'hostname',
				'value' => $this->session->userdata('hostname')
			));
		?>
	</p>
	<p>
		<?php echo lang('username','username'); ?>
		<?php
			echo form_input(array(
				'id' => 'username',
				'name' => 'username',
				'value' => $this->session->userdata('username')
			));
		?>
	</p>
	<p>
		<?php echo lang('password','password'); ?>
		<?php
			echo form_password(array(
				'id' => 'password',
				'name' => 'password',
				'value' => $this->session->userdata('password')
			));
		?>
	</p>
	<p>
		<?php echo lang('portnr','port'); ?>
		<?php
			echo form_input(array(
				'id' => 'port',
				'name' => 'port',
				'value' => set_value('port', $port)
			));
		?>
	</p>
	
	<div id="notification">
	   <p class="text" id="confirm_db"></p>
	</div>
	
	<h3>{server_settings}</h3>

	<p>
		<?php echo lang('httpserver','http_server'); ?>
		<?php
			echo form_dropdown('http_server', $server_options, $this->session->userdata('http_server'), 'id="http_server"');
		?>
	</p>
	
	<input type="hidden" name="installation_step" value="step_1" />
	
	<p id="next_step"><input type="submit" id="submit" value="{step2}" /></p>
	<br class="clear" />
<?php echo form_close(); ?>
