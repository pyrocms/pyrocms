<!-- Intro page -->
<h3>{header}</h3>

<p>{intro_text}</p>

<hr>

<?php echo form_open(uri_string(), 'id="install_frm"'); ?>

	<div class="database">
		<h3>{db_settings}</h3>

		<p>{db_text}</p>
		
		<div class="block-message">
		<div class="input">
			<label for="hostname">{server}</label><br>
			<?php
			echo form_input(array(
				'id' => 'hostname',
				'name' => 'hostname',
				'value' => set_value('hostname', 'localhost'),
			));
		?>
		</div>
		<div class="input">
			<?php echo lang('username','username'); ?><br>
			<?php
				echo form_input(array(
					'id' => 'username',
					'name' => 'username',
					'value' => set_value('username')
				));
			?>
		</div>
		<div class="input">
			<?php echo lang('password','password'); ?><br>
			<?php
				echo form_password(array(
					'id' => 'password',
					'name' => 'password',
					'value' => set_value('password')
				));
			?>
		</div>
		<div class="input">
			<?php echo lang('portnr','port'); ?><br>
			<?php
				echo form_input(array(
					'id' => 'port',
					'name' => 'port',
					'value' => set_value('port', $port)
				));
			?>
		</div>
		</div>
	</div>

	<div id="notification">
	   <p class="text" id="confirm_db"></p>
	</div>
	
	<hr>
	
	<div class="server">
		<h3>{server_settings}</h3>

		<p>{httpserver_text}</p>
		
		<div class="input">
			<?php echo lang('httpserver','http_server'); ?>
			<?php
				echo form_dropdown('http_server', $server_options, set_value('http_server'), 'id="http_server"');
			?>
		</div>
	</div>

	<input type="hidden" name="installation_step" value="step_1" />

	<hr>

	<input id="next_step" type="submit" id="submit" value="{step2}" />

<?php echo form_close(); ?>
