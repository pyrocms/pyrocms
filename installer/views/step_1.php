<!-- Intro page -->
<h1>{header}</h1>

<p>{intro_text}</p>

<?php echo form_open(uri_string(), 'id="install_frm"'); ?>

	<div class="database">
		<h2>{db_settings}</h2>

		<p>{db_text}</p>

		<div class="input">
			<label for="hostname">{server}</label>
			<?php
			echo form_input(array(
				'id' => 'hostname',
				'name' => 'hostname',
				'value' => set_value('hostname')
			));
		?>
		</div>
		<div class="input">
			<?php echo lang('username','username'); ?>
			<?php
				echo form_input(array(
					'id' => 'username',
					'name' => 'username',
					'value' => set_value('username')
				));
			?>
		</div>
		<div class="input">
			<?php echo lang('password','password'); ?>
			<?php
				echo form_password(array(
					'id' => 'password',
					'name' => 'password',
					'value' => set_value('password')
				));
			?>
		</div>
		<div class="input">
			<?php echo lang('portnr','port'); ?>
			<?php
				echo form_input(array(
					'id' => 'port',
					'name' => 'port',
					'value' => set_value('port', $port)
				));
			?>
		</div>

	</div>

	<div id="notification">
	   <p class="text" id="confirm_db"></p>
	</div>

	<div class="server">
		<h2>{server_settings}</h2>

			<div class="input">
				<?php echo lang('httpserver','http_server'); ?>
				<?php
					echo form_dropdown('http_server', $server_options, set_value('http_server'), 'id="http_server"');
				?>
			</div>
	</div>

	<input type="hidden" name="installation_step" value="step_1" />

	<br class="clear" />

	<input id="next_step" type="submit" id="submit" value="{step2}" />

<?php echo form_close(); ?>
